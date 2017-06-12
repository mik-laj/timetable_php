<?php

namespace TimetableBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Subject
 *
 * @ORM\Table(name="subject")
 * @ORM\Entity(repositoryClass="TimetableBundle\Repository\SubjectRepository")
 */
class Subject
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
     * @var ArrayCollection|StudentGroup[] $events
     *
     * @ORM\OrderBy({
     *     "day" = "ASC",
     *     "startTime.hour" = "ASC",
     *     "startTime.minute" = "ASC"
     * })
     * @ORM\OneToMany(targetEntity="TimetableBundle\Entity\Event", mappedBy="tutor")
     */
    private $events;


    public function __construct()
    {
        $this->events = new ArrayCollection();
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Subject
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
     * Get events
     *
     * @return StudentGroup[]|ArrayCollection
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
