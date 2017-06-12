<?php

namespace TimetableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use TimetableBundle\Entity\Event;
use TimetableBundle\Entity\Field;

/**
 * Student group
 *
 * @ORM\Table(
 *     name="student_group",
 *     indexes={
 *          @ORM\Index(name="fk_student_group_field1_idx", columns={"field_id"})
 *      })
 * @ORM\Entity(repositoryClass="TimetableBundle\Repository\StudentGroupRepository")
 */
class StudentGroup
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var Field
     *
     * @ORM\ManyToOne(targetEntity="TimetableBundle\Entity\Field", inversedBy="studentGroups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="field_id", referencedColumnName="id")
     * })
     */
    private $field;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OrderBy({
     *     "day" = "ASC",
     *     "startTime.hour" = "ASC",
     *     "startTime.minute" = "ASC"
     * })
     * @ORM\ManyToMany(targetEntity="TimetableBundle\Entity\Event", mappedBy="student_groups", cascade={"all"})
     */
    private $events;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return StudentGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * Set field
     *
     * @param \TimetableBundle\Entity\Field $field
     *
     * @return StudentGroup
     */
    public function setField(\TimetableBundle\Entity\Field $field = null)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return \TimetableBundle\Entity\Field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Add event
     *
     * @param Event $event
     *
     * @return StudentGroup
     */
    public function addEvent(Event $event)
    {
        $this->events[] = $event;
        return $this;
    }

    /**
     * Remove event
     *
     * @param Event $event
     */
    public function removeEvent(Event $event)
    {
        $this->events->removeElement($event);

    }

    /**
     * Get event
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    function __toString()
    {
        return $this->name;
    }
}
