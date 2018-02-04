<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/2/18
 * Time: 6:28 PM
 */

namespace UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use FOS\UserBundle\Event\GetResponseUserEvent;
use UserBundle\Entity\User;

class AddUserVarAfterEditInitialize implements EventSubscriberInterface
{
    protected $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function onEditInitialize(GetResponseUserEvent $event) {

        /** @var User $user */
        $user = $event->getUser();

        $this->twig->addGlobal('user', $user);
    }

    public static function getSubscribedEvents(){
        return [
            FOSUserEvents::PROFILE_EDIT_INITIALIZE => 'onEditInitialize'
        ];
    }
}