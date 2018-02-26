<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/1/18
 * Time: 1:59 PM
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use ObservationBundle\Service\MapData;

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
        $lastThreeObservations = $em->getRepository('ObservationBundle:Observation')->getLastValidatedWithImage(5);

       $observations = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ObservationBundle:Observation')
            ->findAllValidated();

        $obsJson = $this->get('observation.mapdata')->setMapMarkers($observations);

        return $this->render('AppBundle:App:index.html.twig', array(
            'lastThreeArticles' => $lastThreeArticles,
            'lastThreeObservations' => $lastThreeObservations,
            'obsJson'       => $obsJson
        ));
    }

    /**
     * Landing page
     *
     * @return Response
     */
    public function landingPageAction() {
        return $this->render('AppBundle:App:landingPage.html.twig');
    }

    /**
     * @return Response
     */
    public function quizAction() {
        return $this->render('AppBundle:App:quiz.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createContactFormAction(Request $request) {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class, array(
                'attr' => [
                    'placeholder' => 'Adresse mail'
                ]
            ))
            ->add('object', TextType::class, array(
                'attr' => [
                    'placeholder' => 'Objet du message'
                ],
                'label' => 'Objet'
            ))
            ->add('content', TextAreaType::class, array(
                'attr' => [
                    'placeholder' => 'Contenu du message'
                ]
            ))
            ->add('envoyer', SubmitType::class, array(
                'attr' => [
                    'class' => 'btn btn-nao',
                ]
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new \Swift_Message($form->getData()['object']))
                ->setFrom($form->getData()['email'])
                ->setTo('gatienhrd@gmail.com')
                ->setBody('Coucou')
            ;

            $this->get('mailer')->send($message);

            return $this->redirectToRoute('nao_home');
        }

        return $this->render('AppBundle:App:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function searchBarAction() {

    }
}