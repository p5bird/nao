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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Application controller
 *
 * @Route("/")
 */
class AppController extends Controller {

    /**
     * Index
     *
     * @Route("/", name="nao_home")
     * @return Response
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        return $this->render('AppBundle:App:index.html.twig');
    }
}