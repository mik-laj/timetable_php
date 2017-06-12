<?php
/**
 * Created by PhpStorm.
 * User: andrzej
 * Date: 11.06.17
 * Time: 23:48
 */

namespace TimetableBundle;


use TimetableBundle\Entity\Event;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

class TimetableManager
{

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    private function createEventsQueryBuilder() {
        $repo = $this->em->getRepository(Event::class);
        $qb = $repo->createQueryBuilder('event');
        $qb->join('event.subject', 'subject')->addSelect('subject');
        return $qb;
    }

    public function getGroupedEventForTutor($id) {
        $qb = $this->createEventsQueryBuilder();
        $qb->join('event.tutor', 'tutor')->addSelect('tutor');
        $qb->where('tutor.id = :id')->setParameter('id', $id);
        return $this->groupEventByDay($qb->getQuery()->getResult());
    }

    public function getGroupedEventForStudentGroup($id) {
        $qb = $this->createEventsQueryBuilder();
        $qb->join('event.student_groups', 'student_group')->addSelect('student_group');
        $qb->where('student_group.id = :id')->setParameter('id', $id);
        return $this->groupEventByDay($qb->getQuery()->getResult());
    }

    public function getGroupedEventForSubject($id) {
        $qb = $this->createEventsQueryBuilder();
        $qb->join('event.subject', 'subject')->addSelect('subject');
        $qb->where('subject.id = :id')->setParameter('id', $id);
        return $this->groupEventByDay($qb->getQuery()->getResult());
    }

    public function getGroupedEventForRoom($id) {
        $qb = $this->createEventsQueryBuilder();
        $qb->join('event.room', 'room')->addSelect('room');
        $qb->where('room.id = :id')->setParameter('id', $id);
        return $this->groupEventByDay($qb->getQuery()->getResult());
    }


    private function groupEventByDay(array $events){
        $collection = new ArrayCollection($events);
        $results = [];
        for($i = 1 ; $i <= 7; $i++){
            $results[$i] = $collection ->filter(function(Event $event) use($i) {
               return $event->getDay() == $i;
            });
        }
        return $results;
    }
}