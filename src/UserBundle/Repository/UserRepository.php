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

    public function countAllUsers(){
        $qb = $this->_em->createQueryBuilder();

        $qb->select('count(u.id)')
            ->from('UserBundle:User', 'u');

        return $qb->getQuery()->getSingleScalarResult();
    }
}