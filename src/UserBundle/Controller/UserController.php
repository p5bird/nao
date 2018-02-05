<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/1/18
 * Time: 1:59 PM
 */

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Application controller
 */
class UserController extends Controller {

    /**
     * Show other users profile
     *
     * @param Request $request
     * @param $id
     * @return Response
     * @throws \Exception
     * @throws \Twig\Error\Error
     * @Route("/user/{id}/", name="nao_show_user")
     */
    public function showUserAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);

        if (null == $user) {
            return $this->render('error/404.html.twig');
        }

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