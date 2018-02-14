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

            if (!$observation->getNoName()) {
                $taxonRepository = $this->getDoctrine()->getManager()->getRepository('ObservationBundle:Taxon');
                $taxon = $taxonRepository->findByNameVern($observation->getBirdName());
                $observation->setTaxon($taxon);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($observation);
            $entityManager->flush();

            $session = $request->getSession();
            $session->getFlashBag()->add('alert', [
                'type'      => 'success',
                'content'   => 'Votre observation est enregistrée :)'
            ]);

            return $this->redirectToRoute('nao_obs_check', ['id' => $observation->getId()]);
        }

        return $this->render('ObservationBundle:Observation:add.html.twig', [
            'formObs'   => $formObs->createView()
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


        if ($observation->getNoName())
        {
            $taxon = new Taxon();
            $observation->setTaxon($taxon);
        }

        $formObs = $this->createForm(ObservationType::class, $observation);
        $formObs->handleRequest($request);

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

    	return $this->render('ObservationBundle:Observation:check.html.twig', [
        	'observation'	=> $observation,
            'user'          => $user,
            'formObs'       => $formObs->createView()
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

        if (!is_null($observation) and $observation->getNoName())
        {
            $taxon = new Taxon();
            $observation->setTaxon($taxon);
        }

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
                ['validated' => false],
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


    //\\//\\//\\//
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
}
