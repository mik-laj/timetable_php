<?php

namespace TimetableBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event", indexes={
 *     @ORM\Index(name="fk_event_tutor1_idx", columns={"tutor_id"}),
 *     @ORM\Index(name="fk_event_subject1_idx", columns={"subject_id"})
 * })
 * @ORM\Entity(repositoryClass="TimetableBundle\Repository\EventRepository")
 */
class Event
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var SimpleTime
     *
     * @ORM\Embedded(class="TimetableBundle\Entity\SimpleTime", columnPrefix="start_")
     */
    private $startTime;

    /**
     * @var SimpleTime
     *
     * @ORM\Embedded(class="TimetableBundle\Entity\SimpleTime", columnPrefix="end_")
     */
    private $endTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="day", type="smallint", nullable=false)
     */
    private $day;

    /**
     * @var \TimetableBundle\Entity\Subject
     *
     * @ORM\ManyToOne(targetEntity="TimetableBundle\Entity\Subject", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subject_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $subject;

    /**
     * @var \AppBundle\Entity\Tutor
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tutor", inversedBy="events")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tutor_id", referencedColumnName="id")
     * })
     */
    private $tutor;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TimetableBundle\Entity\StudentGroup", inversedBy="events", cascade={"all"})
     * @ORM\JoinTable(name="event_student_group",
     *   joinColumns={
     *     @ORM\JoinColumn(name="event_id", referencedColumnName="id", nullable=false )
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="student_group_id", referencedColumnName="id", nullable=false)
     *   }
     * )
     */
    private $student_groups;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->student_groups = new ArrayCollection();
    }


    /**
     * Set start time
     *
     * @param SimpleTime|string $startTime
     * @return Event
     */
    public function setStartTime(SimpleTime $startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get start time
     *
     * @return SimpleTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set end time
     *
     * @param SimpleTime $endTime
     *
     * @return Event
     */
    public function setEndTime(SimpleTime $endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get end time
     *
     * @return SimpleTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set day
     *
     * @param integer $day
     *
     * @return Event
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return integer
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set subject
     *
     * @param \AppBundle\Entity\Subject $subject
     *
     * @return Event
     */
    public function setSubject(\AppBundle\Entity\Subject $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \AppBundle\Entity\Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set tutor
     *
     * @param \AppBundle\Entity\Tutor $tutor
     *
     * @return Event
     */
    public function setTutor(\AppBundle\Entity\Tutor $tutor = null)
    {
        $this->tutor = $tutor;

        return $this;
    }

    /**
     * Get tutor
     *
     * @return \AppBundle\Entity\Tutor
     */
    public function getTutor()
    {
        return $this->tutor;
    }

    /**
     * Add student group
     *
     * @param \TimetableBundle\Entity\StudentGroup $studentGroup
     *
     * @return Event
     */
    public function addStudentGroup(\TimetableBundle\Entity\StudentGroup $studentGroup)
    {
        if ($this->student_groups->contains($studentGroup)) {
            return $this;
        }

        $this->student_groups[] = $studentGroup;
        $studentGroup->addEvent($this);

        return $this;
    }

    /**
     * Remove student group
     *
     * @param \TimetableBundle\Entity\StudentGroup $studentGroup
     * @return $this
     */
    public function removeStudentGroup(\TimetableBundle\Entity\StudentGroup $studentGroup)
    {
        if (!$this->student_groups->contains($studentGroup)) {
            return $this;
        }

        $this->student_groups->removeElement($studentGroup);
        $studentGroup->removeEvent($this);

        return $this;
    }

    /**
     * Get student groups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudentGroups()
    {
        return $this->student_groups;
    }
    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    function __toString()
    {
        return $this->startTime . ' ' . $this->endTime . ' : ' . $this->subject->getName();
    }
}
