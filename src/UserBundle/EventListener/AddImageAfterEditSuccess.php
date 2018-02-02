<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/2/18
 * Time: 6:28 PM
 */

namespace UserBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use UserBundle\Entity\User;
use UserBundle\Entity\Avatar;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class AddImageAfterEditSuccess implements EventSubscriberInterface
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onEditSuccess(FormEvent $event) {
        $user = new User();
        $avatar = new Avatar();

        $avatar->setUser($user);
        /*$response = new Response($action);
        $event->setResponse($response);*/
    }

    public static function getSubscribedEvents(){
        return [
            FOSUserEvents::PROFILE_EDIT_SUCCESS => 'onEditSuccess'
        ];
    }
}