<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/12/18
 * Time: 2:36 PM
 */

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository {

    public function getUsersFromDate(\DateTime $date){
        $qb = $this->_em->createQueryBuilder();
        $date->modify('first day of this month');

        $qb->select('count(u.id)')
            ->from('UserBundle:User', 'u')
            ->where('u.dateRegister < :date')
            ->setParameter('date', $date);

        return $qb->getQuery()->getSingleScalarResult();
    }
}