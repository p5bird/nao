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
     * @Security("has_role('ROLE_USER')")
     */
    public function showUserAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);
        $lastThreeObservations = $em->getRepository('ObservationBundle:Observation')->getForUser($user, 3);

        if (null == $user) {
            return $this->render('error/404.html.twig');
        }

        return $this->render('UserBundle:User:showUser.html.twig', array(
            'user' => $user,
            'lastThreeObservations' => $lastThreeObservations
        ));
    }

    /**
     * Edit other users profile
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
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
     * Deactivate user
     *
     * @param $id
     * @return RedirectResponse
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deactivateUserAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);

        $user->setEnabled(0);
        $em->flush();

        return $this->redirectToRoute('nao_list_users');
    }

    /**
     * Activate user
     *
     * @param $id
     * @return RedirectResponse
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function activateUserAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);

        $user->setEnabled(1);
        $em->flush();

        return $this->redirectToRoute('nao_list_users');
    }

    /**
     * List all users
     *
     * @return Response
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
     * @Security("has_role('ROLE_USER')")
     */
    public function dashboardAction() {
        return $this->render('UserBundle:User:dashboard.html.twig');
    }

    /**
     * Statistics
     *
     * @return Response
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function statsAction() {
        $em = $this->getDoctrine()->getManager();

        $users = count($em->getRepository('UserBundle:User')->findAll());
        $articles = count($em->getRepository('BlogBundle:Article')->findAll());
        $comments = count($em->getRepository('BlogBundle:Comment')->findAll());
        $observations = count($em->getRepository('ObservationBundle:Observation')->findAll());

        $dateNow = new \DateTime('+1 month');
        $list = [];

        for ($i = 0; $i < 5; $i++) {
            $list[$i]['users'] = $em->getRepository('UserBundle:User')->getUsersFromDate($dateNow);
            $list[$i]['articles'] = $em->getRepository('BlogBundle:Article')->getArticlesFromDate($dateNow);
            $list[$i]['comments'] = $em->getRepository('BlogBundle:Comment')->getCommentsFromDate($dateNow);
            $list[$i]['observations'] = $em->getRepository('ObservationBundle:Observation')->getObservationsFromDate($dateNow);

            $dateNow->modify('-1 month');
            $list[$i]['date'] = $dateNow->format('Y/m');
        }

        return $this->render('UserBundle:User:stats.html.twig', array(
            'users' => $users,
            'graphData' => $list,
            'articles' => $articles,
            'comments' => $comments,
            'observations' => $observations
        ));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @Route("/{id}/editUserAvatar", name="nao_edit_user_avatar")
     * @Security("has_role('ROLE_USER')")
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