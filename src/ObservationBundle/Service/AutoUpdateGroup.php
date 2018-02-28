<?php

namespace ObservationBundle\Service;

use Doctrine\ORM\EntityManager;
use ObservationBundle\Entity\Observation;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class AutoUpdateGroup {

    private $em;
    private $roleService;

    public function __construct(EntityManager $em, AuthorizationChecker $roleService)
    {
        $this->em = $em;
        $this->roleService = $roleService;
    }

    public function autoUpdateGroup(Observation $observation) {
        $em = $this->em;
        $user = $observation->getAuthor();
        $count = $em->getRepository('ObservationBundle:Observation')->findAllUserValidated($user);

        switch (true){
            case $count >= 5 :
                $group = $em->getRepository('UserBundle:Group')->findOneBy(['name' => 'Colibri']);
                break;
            case $count >= 50 :
                $group = $em->getRepository('UserBundle:Group')->findOneBy(['name' => 'Pivert']);
                break;
            case $count >= 200 :
                $group = $em->getRepository('UserBundle:Group')->findOneBy(['name' => 'Faucon']);
                break;
            case $count >= 500 :
                $group = $em->getRepository('UserBundle:Group')->findOneBy(['name' => 'Condor']);
                break;
            default :
                $group = null;
                break;
        }

        if ($group) {
            foreach ($user->getGroups() as $userGroup) {
                $user->removeGroup($userGroup);
            }

            $user->addGroup($group);
        }

        if(!array_intersect($user->getRoles(), ['ROLE_ADMIN', 'ROLE_NATURALISTE', 'ROLE_SPECIALISTE'])){
            $user->setRoles($group->getRoles());
        }

        $em->flush();

        return true;
    }

}