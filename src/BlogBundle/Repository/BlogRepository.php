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

    public function getArticlesFromDate(\DateTime $date) {
        $qb = $this->_em->createQueryBuilder();
        $date->modify('first day of this month');

        $qb->select('count(a.id)')
            ->from('BlogBundle:Article', 'a')
            ->where('a.createdAt < :date')
            ->setParameter('date', $date);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getCommentsFromDate(\DateTime $date) {
        $qb = $this->_em->createQueryBuilder();
        $date->modify('first day of this month');

        $qb->select('count(c.id)')
            ->from('BlogBundle:Comment', 'c')
            ->where('c.createdAt < :date')
            ->setParameter('date', $date);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getLastThreeArticles() {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('a')
            ->from('BlogBundle:Article', 'a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(3);

        return $qb->getQuery()->getResult();
    }
}