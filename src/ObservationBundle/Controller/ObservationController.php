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

        if ($request->isMethod('POST'))
        {
            $formObs->handleRequest($request);
            if ($formObs->isValid())
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
        }

        return $this->render('ObservationBundle:Observation:add.html.twig', [
            'formObs'   => $formObs->createView()
        ]);
    }

    /**
     * @Route("/observation/check/{id}", name="nao_obs_check")
     * @Security("has_role('ROLE_USER')")
     */
    public function checkAction($id)
    {
        $observation = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ObservationBundle:Observation')
            ->findOneBy(['id' => $id]);

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        // TO-DO-LIST 
        // create form
        // -> observation form
        // -> validation form      

    	return $this->render('ObservationBundle:Observation:check.html.twig', [
        	'observation'	=> $observation,
            'user'          => $user
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

        if ($observation->getNoName())
        {
            $taxon = new Taxon();
            $observation->setTaxon($taxon);
        }

        return $this->render('ObservationBundle:Observation:show.html.twig', [
        	'observation'	=> $observation
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
