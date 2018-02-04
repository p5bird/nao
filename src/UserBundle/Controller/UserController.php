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
use UserBundle\Entity\User;

/**
 * Application controller
 *
 * @Route("/dashboard")
 */
class UserController extends Controller {

    /**
     * @param User $user
     * @return Response
     * @throws \Twig\Error\Error
     */
    public function showUserAction(User $user) {
        $content = $this->get('templating')->render('@User/User/showUser.html.twig', array(
            'user' => $user
        ));

        return new Response($content);
    }

    /**
     * Dashboard
     *
     * @Route("/dashboard", name="nao_dashboard")
     * @return Response
     */
    public function dashboardAction() {
        $em = $this->getDoctrine()->getManager();

        return $this->render('UserBundle:User:dashboard.html.twig');
    }

    /**
     * Admin
     *
     * @Route("/admin", name="nao_admin")
     * @return Response
     */
    public function adminAction() {
        $em = $this->getDoctrine()->getManager();

        return $this->render('UserBundle:User:admin.html.twig');
    }
}