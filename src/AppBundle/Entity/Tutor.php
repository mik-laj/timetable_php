<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use TimetableBundle\Entity\Event;
use TimetableBundle\Entity\StudentGroup;

/**
 * Tutor
 *
 * @ORM\Table(name="tutor", indexes={
 *     @ORM\Index(name="fk_tutor_room1_idx", columns={"room_id"}),
 *     @ORM\Index(name="fk_tutor_organization_unit1_idx", columns={"organization_unit_id"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TutorRepository")
 */
class Tutor
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
     * @ORM\Column(name="first_name", type="string", length=64, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=64, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email(checkMX=true)
     */
    private $email;

    /**
     * @var \AppBundle\Entity\OrganizationUnit
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrganizationUnit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="organization_unit_id", referencedColumnName="id")
     * })
     */
    private $organizationUnit;

    /**
     * @var \AppBundle\Entity\Room
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Room", inversedBy="tutors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     * })
     */
    private $room;

    /**
     * @var ArrayCollection|Event[] $events
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Tutor
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Tutor
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Tutor
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set organizationUnit
     *
     * @param \AppBundle\Entity\OrganizationUnit $organizationUnit
     *
     * @return Tutor
     */
    public function setOrganizationUnit(\AppBundle\Entity\OrganizationUnit $organizationUnit = null)
    {
        $this->organizationUnit = $organizationUnit;

        return $this;
    }

    /**
     * Get organizationUnit
     *
     * @return \AppBundle\Entity\OrganizationUnit
     */
    public function getOrganizationUnit()
    {
        return $this->organizationUnit;
    }

    /**
     * Set room
     *
     * @param \AppBundle\Entity\Room $room
     *
     * @return Tutor
     */
    public function setRoom(\AppBundle\Entity\Room $room = null)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room
     *
     * @return \AppBundle\Entity\Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
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
        return $this->firstName . ' ' . $this->lastName;
    }


}
