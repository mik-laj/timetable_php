<?php

namespace TimetableBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EventRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class EventRepository extends EntityRepository
{
    public function findAllQueryBuilder() {
        return $this->createQueryBuilder('event');
    }

    public function findListQueryBuilder() {
        $qb = $this->findAllQueryBuilder();
        $qb->join('event.subject', 'subject')->addSelect('subject');
        $qb->join('event.tutor', 'tutor')->addSelect('tutor');
        return $qb;
    }

    public function findWithJoins($id) {
        $qb = $this->findAllQueryBuilder();
        $qb->join('event.subject', 'subject')->addSelect('subject');
        $qb->join('event.tutor', 'tutor')->addSelect('tutor');
        $qb->leftjoin('event.student_groups', 'student_group')->addSelect('student_group');
        $qb->where('event.id = :id')->setParameter('id', $id);
        return $qb->getQuery()->getSingleResult();
    }
}
