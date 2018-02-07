<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/6/18
 * Time: 7:12 PM
 */

namespace UserBundle\DataFixtures\ORM;

use UserBundle\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGroups extends Fixture {

    public function load(ObjectManager $manager)
    {
        $options = array(
            'Poussin' => array('ROLE_USER'),
            'Colibri' => array('ROLE_USER'),
            'Pivert' => array('ROLE_USER'),
            'Faucon' => array('ROLE_SPECIALISTE'),
            'Condor' => array('ROLE_SPECIALISTE'),
        );

        foreach ($options as $key => $value) {

            $group = new Group($key, $value);

            $manager->persist($group);

            $manager->flush();
        }

        $manager->flush();
    }
}