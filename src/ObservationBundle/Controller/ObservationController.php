<?php

namespace ObservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use ObservationBundle\Entity\Observation;
use ObservationBundle\Entity\Taxon;
use ObservationBundle\Entity\Image;
use ObservationBundle\Entity\Validation;
use ObservationBundle\Entity\Search;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use ObservationBundle\Form\ObservationType;
use ObservationBundle\Form\ObservationAddType;
use ObservationBundle\Form\ObservationCheckType;
use ObservationBundle\Form\ValidationType;
use ObservationBundle\Form\SearchType;

use ObservationBundle\Service\SearchFiltered;
use ObservationBundle\Service\Geoloc;
use ObservationBundle\Service\TaxonFinder;
use ObservationBundle\Service\ObsValidation;
use ObservationBundle\Service\MapData;

use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ObservationController extends Controller
{
    /**
     * @Route("/observation/add", name="nao_obs_add")
     * @Security("has_role('ROLE_USER')")
     */
    public function addAction(Request $request)
    {
        $observation = new Observation();
        $formObs = $this->createForm(ObservationAddType::class, $observation);

        $formObs->handleRequest($request);
        if ($formObs->isSubmitted() and $formObs->isValid())
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $observation->setAuthor($user);

            $observation = $this->get('observation.taxonFinder')->setTaxonToObservation($observation);

            $observation = $this->get('observation.geoloc')->setLocationInfos($observation);

            if ($observation->hasImage() === true)
            {
                $image = $observation->getImage();
                $observation->setImage($image);
            }
            else
            {
                $observation->setImage(null);
            }

            // valid button clicked =>
            // publish asked by user and also validation required
            if ($formObs->get('valid')->isClicked())
            {
                $observation->setPublish(true);

                if ($user->hasRole('ROLE_NATURALISTE') and $observation->hasTaxon())
                {
                    $observation = $this->get('observation.obsValidation')->setGranted($observation);
                }
            }

            // save button clicked =>
            // just save in db without ask publish 
            // and also doesn't need validation
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
        $entityManager = $this->getDoctrine()->getManager();

        $observation = $entityManager
            ->getRepository('ObservationBundle:Observation')
            ->findOneBy(['id' => $id]);

        if (is_null($observation))
        {
            return $this->render('ObservationBundle:Observation:edit.html.twig', [
                'observation'   => $observation
            ]);            
        }

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $formObs = $this->createForm(ObservationAddType::class, $observation);
        $formObs->handleRequest($request);

        if ($formObs->isSubmitted() and $formObs->isValid())
        {
            $author = $observation->getAuthor();
            $observation->setAuthor($author);

            $observation = $this->get('observation.taxonFinder')->setTaxonToObservation($observation);

            $observation = $this->get('observation.geoloc')->setLocationInfos($observation);

            // set or remove image
            if ($observation->hasImage() === true)
            {
                if ($observation->needRemoveImage() === true or $observation->needRemoveImage() == "true")
                {
                    $entityManager->remove($observation->getImage());
                    $observation->setImage(null);
                }
                else
                {
                    $image = $observation->getImage();
                    $observation->setImage($image);
                }
            }

            // valid button clicked =>
            // publish asked by user and also validation required
            if ($formObs->get('valid')->isClicked())
            {
                // remove validation is observation already has validation
                if ($observation->hasValidation())
                {
                    $entityManager->remove($observation->getValidation());
                    $observation->setValidation(null);
                }

                if ($user->hasRole('ROLE_NATURALISTE') and $observation->hasTaxon())
                {
                    $observation = $this->get('observation.obsValidation')->setGranted($observation);
                }

                $observation->setPublish(true);
            }

            // save button clicked =>
            // just save in db without ask publish 
            // and also doesn't need validation
            if ($formObs->get('save')->isClicked())
            {
                $observation = $this->get('observation.obsValidation')->cancelValidation($observation);
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
            'user'          => $user,
            'formObs'       => $formObs->createView()
        ]);
    }



    /**
     * @Route("/observation/check/{id}", name="nao_obs_check")
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    public function checkAction($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        if ($session->has('observation') and $session->get('observation')->getId() == $id)
        {
            $observation = $session->get('observation');
            $session->remove('observation');
        }
        else
        {
            $observation = $entityManager
                ->getRepository('ObservationBundle:Observation')
                ->findOneBy(['id' => $id]); 
        }


        if (is_null($observation))
        {
            return $this->render('ObservationBundle:Observation:check.html.twig', [
                'observation'   => $observation
            ]);            
        }

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $formValid = $this->createForm(ObservationCheckType::class, $observation);
        $formValid->handleRequest($request);

        if ($formValid->isSubmitted() and $formValid->isValid())
        {
            $author = $observation->getAuthor();
            $observation->setAuthor($author);

            $image = $observation->getImage();
            $observation->setImage($image);

            $observation = $this->get('observation.taxonFinder')->setTaxonToObservation($observation);

            // cancel button clicked =>
            // return to check list
            if ($formValid->get('cancel')->isClicked())
            {
                return $this->redirectToRoute('nao_obs_check_list');
            }

            // valid button clicked =>
            // obs validated
            if ($formValid->get('valid')->isClicked())
            {
                // no taxon related to the observation =>
                // this means Observation IS NOT VALID !
                if (!$observation->hasTaxon())
                {
                    $session->getFlashBag()->add('alert', [
                        'type'      => 'danger',
                        'content'   => "Attention !! Il manque l'identification de l'oiseau !"
                    ]);

                    $session->set('observation', $observation);
                    
                    return $this->redirectToRoute('nao_obs_check', ['id' => $id]);
                }

                $observation = $this->get('observation.obsValidation')->setGranted($observation);;
            }

            // reject button clicked =>
            // obs rejected
            if ($formValid->get('reject')->isClicked())
            {
                $observation = $this->get('observation.obsValidation')->setRejected($observation);
            }
        
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
    public function removeAction($id, Request $request)
    {

        $entityManager = $this
            ->getDoctrine()
            ->getManager();

        $observation = $entityManager
            ->getRepository('ObservationBundle:Observation')
            ->findOneBy(['id' => $id]);

        $form = $this->createFormBuilder()
            ->add('cancel', SubmitType::class, [
                'label' => "Annuler"
            ])
            ->add('delete', SubmitType::class, [
                'label' => "Supprimer",
                'attr'  => [
                    'class' => 'btn-danger block-redalert'
                ]
            ])
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->get('delete')->isClicked())
            {
                if ($observation->hasImage())
                {
                    $entityManager->remove($observation->getImage());
                    $observation->setImage(null);
                }
                $entityManager->remove($observation);
                $entityManager->flush();   

                $request
                    ->getSession()
                    ->getFlashBag()
                    ->add('alert', [
                    'type'      => 'success',
                    'content'   => "Observation n°${id} supprimée"
                ]);                             
            }

            return $this->redirectToRoute('nao_obs_user_list');
        }   

        return $this->render('ObservationBundle:Observation:remove.html.twig', [
            'observation'   => $observation,
            'form'          => $form->createView()
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
    public function showCheckListAction(Request $request)
    {
        $obsRepository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ObservationBundle:Observation');

        // $observations = $obsRepository->getNeedValidation();

        //pagination
        $query = $obsRepository->getNeedValidationQuery();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('ObservationBundle:Observation:showCheckList.html.twig', [
            'pagination'   => $pagination
            // 'observations'    => $observations
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

        $observations = $obsRepository->SearchFiltered($search);
        $obsJson = $this->get('observation.mapdata')->setMapMarkers($observations);

        // pagination preparation
        $query = $obsRepository->SearchFilteredQuery($search);
        $paginator = $this->get('knp_paginator');
        $page = $request->query->getInt('page', 1);

        if ($formSearch->isSubmitted() and $formSearch->isValid())
        {
            $session->set('search', $search);
            $page = 1; // Bundle issue fixing : need to be restarted if new search query
        }

        $pagination = $paginator->paginate(
            $query,
            $page,
            10
        );

        return $this->render('ObservationBundle:Observation:search.html.twig', [
            'observations'  => $observations,
            'obsJson'       => $obsJson,
            'formSearch'    => $formSearch->createView(),
            'totalObs'      => $obsRepository->countValidated(),
            'pagination'    => $pagination,
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
}