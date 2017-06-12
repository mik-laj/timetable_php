<?php

namespace TimetableBundle\Controller;

use AppBundle\Entity\Room;
use AppBundle\Entity\Tutor;
use TimetableBundle\Entity\Event;
use TimetableBundle\Entity\StudentGroup;
use TimetableBundle\Entity\Subject;
use TimetableBundle\TimetableManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TimetableController extends Controller
{
    /**
     * @Route("/timetable/tutor/{id}", name="timetable_tutor")
     */
    public function showTutorAction(Tutor $tutor)
    {
        /** @var TimetableManager $manager */
        $manager = $this->get('timetable.manager');

        $events = $manager->getGroupedEventForTutor($tutor->getId());

        return $this->render('timetable/show_timetable.html.twig', array(
            'events' => $events
        ));
    }

    /**
     * @Route("/timetable/student-group/{id}", name="timetable_student_group")
     */
    public function showStudentGroupAction(StudentGroup $studentGroup)
    {
        /** @var TimetableManager $manager */
        $manager = $this->get('timetable.manager');

        $events = $manager->getGroupedEventForStudentGroup($studentGroup->getId());

        return $this->render('timetable/show_timetable.html.twig', array(
            'events' => $events
        ));
    }

    /**
     * @Route("/timetable/subject/{id}", name="timetable_subject")
     */
    public function showSubjectAction(Subject $subject)
    {
        /** @var TimetableManager $manager */
        $manager = $this->get('timetable.manager');

        $events = $manager->getGroupedEventForStudentGroup($subject->getId());

        return $this->render('timetable/show_timetable.html.twig', array(
            'events' => $events
        ));
    }

    /**
     * @Route("/timetable/room/{id}", name="timetable_room")
     */
    public function showRoomAction(Room $room)
    {
        /** @var TimetableManager $manager */
        $manager = $this->get('timetable.manager');

        $events = $manager->getGroupedEventForRoom($room->getId());

        return $this->render('timetable/show_timetable.html.twig', array(
            'events' => $events
        ));
    }

    /**
     * @Route("/timetable/event/{id}/info", name="timetable_info_event")
     */
    public function showEventAction(Event $event)
    {
//        /** @var TimetableManager $manager */
//        $manager = $this->getDoctrine()->getRepository(Event::class);


        return $this->render('timetable/show_event_info.html.twig', array(
            'event' => $event
        ));
    }


}
