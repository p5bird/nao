<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/1/18
 * Time: 1:59 PM
 */

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Application controller
 *
 * @Route("/dashboard")
 */
class UserController extends Controller {

    /**
     * Dashboard
     *
     * @Route("/", name="nao_dashboard")
     * @return Response
     */
    public function dashboardAction() {
        $em = $this->getDoctrine()->getManager();

        return $this->render('UserBundle:User:dashboard.html.twig');
    }

    /**
     * Admin
     *
     * @Route("/", name="nao_admin")
     * @return Response
     */
    public function adminAction() {
        $em = $this->getDoctrine()->getManager();

        return $this->render('UserBundle:User:admin.html.twig');
    }
}