<?php

namespace ObservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use ObservationBundle\Entity\Observation;
use ObservationBundle\Form\ObservationType;

class ObservationController extends Controller
{
    /**
     * @Route("/observation/add", name="nao_obs_add")
     * @Security("has_role('ROLE_USER')")
     */
    public function addAction()
    {

        $observation = new Observation();
        $formObs = $this->createForm(ObservationType::class, $observation);

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
    	return $this->render('ObservationBundle:Observation:check.html.twig', [
        	'obs'	=> ['id' => $id]
        ]);
    }

    /**
     * @Route("/observation/show/{id}", name="nao_obs_show")
     */
    public function showAction($id)
    {
        return $this->render('ObservationBundle:Observation:show.html.twig', [
        	'obs'	=> ['id' => $id]
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
}
