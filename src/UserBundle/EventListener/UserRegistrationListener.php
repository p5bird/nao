<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/6/18
 * Time: 4:28 PM
 */

namespace UserBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;

class UserRegistrationListener implements EventSubscriberInterface {

    protected $em;
    protected $user;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess'
        ];
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        $this->user = $event->getForm()->getData();
        $groupId = array('id' => '1');
        $group = $this->em->getRepository('UserBundle:Group')->findOneBy($groupId);
        $this->user->addGroup($group);
    }

}