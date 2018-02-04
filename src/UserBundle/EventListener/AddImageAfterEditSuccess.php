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


class AddImageAfterEditSuccess implements EventSubscriberInterface
{
    public function onEditSuccess(FormEvent $event) {
        /** @var User $user */
        $user = $event->getForm()->getData();

        if($user->getAvatar()->getId()){
            /** @var Avatar $avatar */
            $avatar = $user->getAvatar();

            if($avatar->getFile()){
                $newAvatar = new Avatar();
                $newAvatar->setFile($avatar->getFile());
                $user->setAvatar($newAvatar);
            }
        }
    }

    public static function getSubscribedEvents(){
        return [
            FOSUserEvents::PROFILE_EDIT_SUCCESS => 'onEditSuccess'
        ];
    }
}