<?php

namespace ObservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use ObservationBundle\Entity\Observation;
use ObservationBundle\Form\ObservationType;
use ObservationBundle\Entity\Taxon;
use ObservationBundle\Entity\Image;
use ObservationBundle\Entity\Validation;
use ObservationBundle\Form\ValidationType;

class ObservationController extends Controller
{
    /**
     * @Route("/observation/add", name="nao_obs_add")
     * @Security("has_role('ROLE_USER')")
     */
    public function addAction(Request $request)
    {
        $observation = new Observation();
        //$image = new Image();
        //$observation->getImages()->add($image);
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
                $image->setObservation($observation);
                $observation->setImage($image);
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
                $image->setObservation($observation);
                $observation->setImage($image);
            }

            $entityManager = $this->getDoctrine()->getManager();

            // remove image
            if ($observation->hasImage() and is_null($observation->getImage()->getImageFile()))
            {
                //$bdImage = $entityManager->getRepository('ObservationBundle:Image')->findOneBy(['observation' => $observation]);
                $entityManager->remove($observation->getImage());
                $observation->setImage(null);
            }

            // remove validation is observation already validated
            if ($observation->isValidated())
            {
                $entityManager->remove($observation->getValidation());
                $observation->removeValidation();
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
            $validation->setAuthor($user);
            $validation->setDate(new \DateTime());
            if ($formValid->get('valid')->isClicked())
            {
                $validation->setGranted(true);
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
     * @Route("/observation/show/{id}", name="nao_obs_show")
     */
    public function showAction($id)
    {

        $observation = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ObservationBundle:Observation')
            ->findOneBy(['id' => $id]);

        return $this->render('ObservationBundle:Observation:show.html.twig', [
        	'observation'	=> $observation
        ]);
    }



    /**
     * @Route("/observation/showUserList", name="nao_obs_user_list")
     * @Security("has_role('ROLE_USER')")
     */
    public function showUserListAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $observations = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ObservationBundle:Observation')
            ->findBy(
                ['author' => $user],
                ['day' => 'desc']
            );

        return $this->render('ObservationBundle:Observation:showUserList.html.twig', [
            'observations'   => $observations
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
            ->findBy(
                ['validation' => null],
                ['sendingDate' => 'desc']
            );

        return $this->render('ObservationBundle:Observation:showCheckList.html.twig', [
            'observations'   => $observations
        ]);
    }



    /**
     * @Route("/observation/search", name="nao_obs_search")
     */
    public function searchAction()
    {
        return $this->render('ObservationBundle:Observation:search.html.twig');
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
}
