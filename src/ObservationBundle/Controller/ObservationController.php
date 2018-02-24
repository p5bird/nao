<?php

namespace ObservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use ObservationBundle\Entity\Observation;
use ObservationBundle\Form\ObservationType;
use ObservationBundle\Entity\Taxon;
use ObservationBundle\Entity\Image;
use ObservationBundle\Entity\Validation;
use ObservationBundle\Form\ValidationType;
use ObservationBundle\Service\Geoloc;
use ObservationBundle\Entity\Search;
use ObservationBundle\Form\SearchType;
use ObservationBundle\Service\SearchFiltered;

class ObservationController extends Controller
{
    /**
     * @Route("/observation/add", name="nao_obs_add")
     * @Security("has_role('ROLE_USER')")
     */
    public function addAction(Request $request)
    {
        $observation = new Observation();
        $formObs = $this->createForm(ObservationType::class, $observation);

        $formObs->handleRequest($request);
        if ($formObs->isSubmitted() and $formObs->isValid())
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $observation->setAuthor($user);

            if (!$observation->hasNoName()) {
                $taxonRepository = $this->getDoctrine()->getManager()->getRepository('ObservationBundle:Taxon');
                $taxon = $taxonRepository->findByNameVern($observation->getBirdName());
                $observation->setTaxon($taxon);
            }

            if ($observation->hasImage())
            {
                $image = $observation->getImage();
                $observation->setImage($image);
            }

            $observation = $this
                ->get('observation.geoloc')
                ->setLocationInfos($observation)
            ;

            if ($formObs->get('valid')->isClicked())
            {
                $observation->setPublish(true);
                if ($user->hasRole('ROLE_NATURALISTE'))
                {
                    $validation = new Validation();
                    $validation->setAuthor($user);
                    $validation->setDate(new \DateTime());
                    $validation->setGranted(true);
                    $observation->setValidation($validation);
                }
            }
            if ($formObs->get('save')->isClicked())
            {
                $observation->setPublish(false);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($observation);
            $entityManager->flush();

            $session = $request->getSession();
            $session->getFlashBag()->add('alert', [
                'type'      => 'success',
                'content'   => 'Votre observation est enregistrée :)'
            ]);

            return $this->redirectToRoute('nao_obs_user_list', ['id' => $observation->getId()]);
        }

        return $this->render('ObservationBundle:Observation:add.html.twig', [
            'formObs'       => $formObs->createView(),
            'observation'   => $observation
        ]);
    }



    /**
     * @Route("/observation/edit/{id}", name="nao_obs_edit")
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction($id, Request $request)
    {
        $observation = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ObservationBundle:Observation')
            ->findOneBy(['id' => $id]);

        if (is_null($observation))
        {
            return $this->render('ObservationBundle:Observation:edit.html.twig', [
                'observation'   => $observation
            ]);            
        }

        $formObs = $this->createForm(ObservationType::class, $observation);
        $formObs->handleRequest($request);

        if ($formObs->isSubmitted() and $formObs->isValid())
        {
            $taxonRepository = $this->getDoctrine()->getManager()->getRepository('ObservationBundle:Taxon');
            $taxon = $taxonRepository->findByNameVern($observation->getBirdName());

            if (!is_null($taxon)) 
            {              
                $observation->setTaxon($taxon);
            }

            if ($observation->hasImage())
            {
                $image = $observation->getImage();
                $observation->setImage($image);
            }

            $entityManager = $this->getDoctrine()->getManager();

            // remove image
            if ($observation->hasImage() and is_null($observation->getImage()->getImageFile()))
            {
                $entityManager->remove($observation->getImage());
                $observation->setImage(null);
            }

            // remove validation is observation already has validation
            if ($observation->hasValidation())
            {
                $entityManager->remove($observation->getValidation());
                $observation->removeValidation();
            }

            $observation = $this
                ->get('observation.geoloc')
                ->setLocationInfos($observation)
            ;

            if ($formObs->get('valid')->isClicked())
            {
                $observation->setPublish(true);
            }
            if ($formObs->get('save')->isClicked())
            {
                $observation->setPublish(false);
            }

            $entityManager->persist($observation);
            $entityManager->flush();

            $session = $request->getSession();
            $session->getFlashBag()->add('alert', [
                'type'      => 'success',
                'content'   => 'Vos modifications ont été prises en compte :)'
            ]);

            return $this->redirectToRoute('nao_obs_user_list');
        }

        return $this->render('ObservationBundle:Observation:edit.html.twig', [
            'observation'   => $observation,
            'user'          => $this->container->get('security.token_storage')->getToken()->getUser(),
            'formObs'       => $formObs->createView()
        ]);
    }



    /**
     * @Route("/observation/check/{id}", name="nao_obs_check")
     * @Security("has_role('ROLE_USER')")
     */
    public function checkAction($id, Request $request)
    {
        $observation = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ObservationBundle:Observation')
            ->findOneBy(['id' => $id]);

        if (is_null($observation))
        {
            return $this->render('ObservationBundle:Observation:check.html.twig', [
                'observation'   => $observation
            ]);            
        }

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $validation = new Validation();
        $formValid = $this->createForm(ValidationType::class, $validation);
        $formValid->handleRequest($request);

        if ($formValid->isSubmitted() and $formValid->isValid())
        {
            if ($formValid->get('cancel')->isClicked())
            {
                return $this->redirectToRoute('nao_obs_check_list');
            }

            $validation->setAuthor($user);
            $validation->setDate(new \DateTime());
            if ($formValid->get('valid')->isClicked())
            {
                $validation->setGranted(true);
            }
            if ($formValid->get('reject')->isClicked())
            {
                $validation->setRejected(true);
            }

            $observation->setValidation($validation);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($observation);
            $entityManager->flush();

            return $this->redirectToRoute('nao_obs_check_list');
        }

    	return $this->render('ObservationBundle:Observation:check.html.twig', [
        	'observation'	=> $observation,
            'user'          => $user,
            'formValid'     => $formValid->createView()
        ]);
    }



    /**
     * @Route("/observation/remove/{id}", name="nao_obs_remove")
     */
    public function removeAction($id)
    {

        $entityManager = $this
            ->getDoctrine()
            ->getManager();

        $observation = $entityManager
            ->getRepository('ObservationBundle:Observation')
            ->findOneBy(['id' => $id]);

        if (empty($observation)) {
            return $this->redirectToRoute('nao_obs_user_list'
            );            
        }
        
        if ($observation->hasImage())
        {
            $entityManager->remove($observation->getImage());
            $observation->setImage(null);
        }
        $entityManager->remove($observation);
        $entityManager->flush();

        return $this->redirectToRoute('nao_obs_user_list');
    }



    /**
     * @Route("/observation/show/{id}", name="nao_obs_show")
     */
    public function showAction($id)
    {

        $observation = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ObservationBundle:Observation')
            ->findOneBy(['id' => $id]);

        if (empty($observation)) {
            return $this->render('ObservationBundle:Observation:show.html.twig', [
                'observation'   => $observation
            ]);            
        }
        
        // // Service Google Geoloc
        // $locationInfos = $this->get('observation.geoloc')->getLocationInfos($observation);

        // echo '<pre>';
        // var_dump($locationInfos); 
        // echo '</pre>'; 

        return $this->render('ObservationBundle:Observation:show.html.twig', [
        	'observation'	=> $observation
        ]);
    }



    /**
     * @Route("/observation/showUserList", name="nao_obs_user_list")
     * @Security("has_role('ROLE_USER')")
     */
    public function showUserListAction(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $obsRepository = $entityManager->getRepository('ObservationBundle:Observation');
    
        $observations = $obsRepository->findAllUser($user);


        $totalObs = $obsRepository->countForUser($user);

        // pagination
        $query = $obsRepository->findAllUserQuery($user);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        $counts['rejected'] = $obsRepository->countUserRejected($user);
        $counts['saved'] = $obsRepository->countUserSaved($user);
        $counts['needValidation'] = $obsRepository->countUserNeedValidation($user);
        $counts['validated'] = $obsRepository->countUserValidated($user);

        return $this->render('ObservationBundle:Observation:showUserList.html.twig', [
            'observations'   => $observations,
            'totalObs'       => $totalObs,
            'pagination'   => $pagination,
            'counts'        => $counts
        ]);
    }



    /**
     * @Route("/observation/showCheckList", name="nao_obs_check_list")
     * @Security("is_granted('ROLE_SPECIALISTE')")
     */
    public function showCheckListAction()
    {
        $observations = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ObservationBundle:Observation')
            ->getNeedValidation();

        return $this->render('ObservationBundle:Observation:showCheckList.html.twig', [
            'observations'   => $observations
        ]);
    }



    /**
     * @Route("/observation/search", name="nao_obs_search")
     */
    public function searchAction(Request $request)
    {
        $obsRepository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ObservationBundle:Observation');

        $session = $request->getSession();

        $search = ($session->has('search')) ? $session->get('search') : new Search();
        $formSearch = $this->createForm(SearchType::class, $search);
        $formSearch->handleRequest($request);

        $obsJson = [];
        $observations = [];

        $observations = $obsRepository->SearchFiltered($search);
        foreach ($observations as $obs) {
            array_push($obsJson, [
                'id'        => $obs->getId(),
                'birdName'  => $obs->getBirdName(),
                'latitude'  => $obs->getLatitude(),
                'longitude' => $obs->getLongitude(),
                'url'       => $this->generateUrl('nao_obs_show', ['id' => $obs->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
                'nameValid'  => $obs->getTaxon()->getNameValid(),
                'date'       => $obs->getDay()->format('d/m/Y h:m')
            ]);
        }

        if ($formSearch->isSubmitted() and $formSearch->isValid())
        {
            $session->set('search', $search);

            // pagination
            $query = $obsRepository->SearchFilteredQuery($search);
            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                10
            );

            return $this->render('ObservationBundle:Observation:search.html.twig', [
                'observations'  => $observations,
                'obsJson'       => json_encode($obsJson),
                'formSearch'    => $formSearch->createView(),
                'totalObs'      => $obsRepository->countValidated(),
                'pagination'    => $pagination,
                'search'        => $search
            ]);

        }

        return $this->render('ObservationBundle:Observation:search.html.twig', [
            'observations'  => $observations,
            'obsJson'       => json_encode($obsJson),
            'formSearch'    => $formSearch->createView(),
            'totalObs'      => $obsRepository->countValidated(),
            'search'        => $search
        ]);
    }



    /**
     * @Route("/observation/result/{view}/{filter}", name="nao_obs_result")
     */
    public function resultAction($view = null, $filter = null)
    {
        return $this->render('ObservationBundle:Observation:result.html.twig');
    }





    /**
     * -------------------------------------------
     * AJAX Call methods
     * -------------------------------------------
     */


    /**
     * @param  string $birdName Partial bird name
     * @return JsonResponse     List of proposed names
     */
    public function birdNameAutoCompleteAction($birdName)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ObservationBundle:Taxon');
        $taxons = $repository->findForAutocomplete($birdName);

        $taxonList = [];
        foreach ($taxons as $taxon) {
            array_push($taxonList, [
                'label' => $taxon->getNameVern() . ' :: ' . $taxon->getNameValid(),
                'value' => $taxon->getNameVern()
            ]);
        }

        return new JsonResponse($taxonList);
    }


    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @Route("/{id}/editUserAvatar", name="nao_edit_user_avatar")
     */
    public function imageCropperAction(Request $request, Observation $observation){
        $em = $this->getDoctrine()->getManager();

        if($data = $request->request->get('image')) {
            $user->getAvatar() ? $avatar = $user->getAvatar() : $avatar = new Avatar();

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = str_replace('data:image/png;base64,', '', $data);
            $data = str_replace(' ', '+', $data);

            $data = base64_decode($data);

            $imageName = 'user-'.$user->getId().'.png';

            file_put_contents('uploads/avatar/'.$imageName, $data);

            $file = new UploadedFile('uploads/avatar/'. $imageName, $imageName,  'image/png');

            $avatar->setUser($user);
            $user->setAvatar($avatar);
            $avatar->setFile($file);
            $em->flush();

            return new JsonResponse("Avatar changed", 200);
        }
        return new JsonResponse("Avatar not changed", 500);
    }

    public function obsMarkerAction(Request $request)
    {
        $session = $request->getSession();
        $search = ($session->has('search')) ? $session->get('search') : new Search();

        $observations = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ObservationBundle:Observation')
            ->SearchFiltered($search);
       
        $obsJson = [];
        foreach ($observations as $obs) {
            array_push($obsJson, [
                'id'        => $obs->getId(),
                'birdName'  => $obs->getBirdName(),
                'latitude'  => $obs->getLatitude(),
                'longitude' => $obs->getLongitude(),
                'url'       => $this->generateUrl('nao_obs_show', ['id' => $obs->getId()], UrlGeneratorInterface::ABSOLUTE_URL)
            ]);
        }
        return new JsonResponse($obsJson);
    }
}
