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
     * Second landing page
     *
     * @return Response
     */
    public function secondLandingPageAction() {
        return $this->render('AppBundle:App:secondLandingPage.html.twig');
    }

    /**
     * Quiz
     *
     * @return Response
     */
    public function quizAction() {
        return $this->render('AppBundle:App:quiz.html.twig');
    }

    /**
     * Join association
     *
     * @return Response
     */
    public function joinAction() {
        return $this->render('AppBundle:App:joinAssociation.html.twig');
    }

    /**
     * Partners
     *
     * @return Response
     */
    public function partnersAction() {
        return $this->render('AppBundle:App:partners.html.twig');
    }

    /**
     * Presse
     *
     * @return Response
     */
    public function presseAction() {
        return $this->render('AppBundle:App:presse.html.twig');
    }

    /**
     * Credits
     *
     * @return Response
     */
    public function creditsAction() {
        return $this->render('AppBundle:App:credits.html.twig');
    }

    /**
     * Create and send contact form
     *
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
                ->setBody($form->getData()['content'])
            ;

            $this->get('mailer')->send($message);

            return $this->redirectToRoute('nao_home');
        }

        return $this->render('AppBundle:App:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Submit footer form
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function submitFooterFormAction(Request $request){
        $data = $request->request->get('formFooter');
        $message = (new \Swift_Message('Contact depuis l\'application'))
            ->setFrom($data['email'])
            ->setTo('gatienhrd@gmail.com')
            ->setBody($data['content'])
        ;

        $this->get('mailer')->send($message);

        return $this->redirectToRoute('nao_home');
    }

    public function searchBarAction() {

    }
}