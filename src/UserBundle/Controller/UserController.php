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
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use UserBundle\Form\EditProfileType;

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
     * Edit other users profile
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     * @Route("/user/{id}/edit/", name="nao_edit_user")
     */
    public function editUserAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);

        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('nao_home');
        }

        return $this->render('@User/User/editUser.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
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