<?php

namespace TimetableBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SubjectRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class SubjectRepository extends EntityRepository
{
    public function search($q, $limit = 10)
    {
        return $this->createQueryBuilder('subject')
            ->where('subject.name LIKE :name')
            ->setParameter('name', '%' . $q . '%')
            ->setMaxResults($limit)
            ->getQuery()->getResult();
    }

    public function findAllQueryBuilder() {
        return $this->createQueryBuilder('subject');
    }

    public function findWithJoins($id) {
        $qb = $this->findAllQueryBuilder();
        $qb->leftjoin('subject.events', 'events')->addSelect('events');
        $qb->where('subject.id = :id')->setParameter('id', $id);
        return $qb->getQuery()->getSingleResult();
    }
}
