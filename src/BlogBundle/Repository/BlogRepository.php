<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/18/18
 * Time: 7:44 PM
 */

namespace BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BlogRepository extends EntityRepository {

    public function countAllArticles(){
        $qb = $this->_em->createQueryBuilder();

        $qb->select('count(a.id)')
            ->from('BlogBundle:Article', 'a');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countAllComments(){
        $qb = $this->_em->createQueryBuilder();

        $qb->select('count(c.id)')
            ->from('BlogBundle:Comment', 'c');

        return $qb->getQuery()->getSingleScalarResult();
    }
}