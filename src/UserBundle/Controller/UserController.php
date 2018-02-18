<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/1/18
 * Time: 1:59 PM
 */

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


use UserBundle\Entity\Avatar;
use UserBundle\Entity\User;
use UserBundle\Form\ProfileType;

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
     * @Route("/user/{id}/", name="nao_show_user")
     */
    public function showUserAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);

        if (null == $user) {
            return $this->render('error/404.html.twig');
        }

        return $this->render('UserBundle:User:showUser.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * Edit other users profile
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     * @Route("/user/{id}/edit/", name="nao_edit_user")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editUserAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);

        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('error/404.html.twig');
        }

        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('nao_home');
        }

        return $this->render('UserBundle:User:editUser.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * List all users
     *
     * @return Response
     * @Route("/user/all/", name="nao_list_users")
     * @Route("/dashboard", name="nao_dashboard")
     * @Security("has_role('ROLE_USER')")
     */
    public function listUsersAction() {

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();

        return $this->render('UserBundle:User:listUsers.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * Dashboard
     *
     * @return Response
     * @Route("/dashboard", name="nao_dashboard")
     * @Security("has_role('ROLE_USER')")
     */
    public function dashboardAction() {
        return $this->render('UserBundle:User:dashboard.html.twig');
    }

    /**
     * Statistics
     *
     * @return Response
     * @Route("/stats", name="nao_stats")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function statsAction() {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->countAllUsers();
        $articles = $em->getRepository('BlogBundle:Article')->countAllArticles();
        $comments = $em->getRepository('BlogBundle:Comment')->countAllComments();

        return $this->render('UserBundle:User:stats.html.twig', array(
            'users' => $users,
            'articles' => $articles,
            'comments' => $comments
        ));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @Route("/{id}/editUserAvatar", name="nao_edit_user_avatar")
     */
    public function editUserAvatarAction(Request $request, User $user){
        $em = $this->getDoctrine()->getManager();

        if($data = $request->request->get('image')) {
            $user->getAvatar() ? $avatar = $user->getAvatar() : $avatar = new Avatar();

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = str_replace('data:image/png;base64,', '', $data);
            $data = str_replace(' ', '+', $data);

            $data = base64_decode($data);

            $imageName = 'user-'.$user->getId().'.png';

            file_put_contents('uploads/avatar/'.$imageName, $data);

            $file = new UploadedFile('uploads/avatar/'. $imageName, $imageName,  'image/png');

            $avatar->setUser($user);
            $user->setAvatar($avatar);
            $avatar->setFile($file);
            $em->flush();

            return new JsonResponse("Avatar changed", 200);
        }
        return new JsonResponse("Avatar not changed", 500);
    }
}