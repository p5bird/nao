<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/1/18
 * Time: 1:59 PM
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Application controller
 */
class AppController extends Controller {

    /**
     * Index
     *
     * @return Response
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getManager();

        $lastThreeArticles = $em->getRepository('BlogBundle:Article')->getLastThreeArticles();

        return $this->render('AppBundle:App:index.html.twig', array(
            'lastThreeArticles' => $lastThreeArticles
        ));
    }
}