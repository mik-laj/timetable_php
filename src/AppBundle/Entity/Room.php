<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Room
 *
 * @ORM\Table(name="room", indexes={
 *     @ORM\Index(name="fk_room_organization_unit1_idx", columns={"organization_unit_id"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoomRepository")
 */
class Room
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
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var \AppBundle\Entity\OrganizationUnit
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrganizationUnit", inversedBy="rooms", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="organization_unit_id", referencedColumnName="id")
     * })
     */
    private $organizationUnit;

    /**
     * @var ArrayCollection|Tutor[] $studentGroups
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Tutor", mappedBy="room")
     */
    private $tutors;


    public function __construct()
    {
        $this->tutors = new ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Room
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
     * Set organizationUnit
     *
     * @param \AppBundle\Entity\OrganizationUnit $organizationUnit
     *
     * @return Room
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
     * Get tutors
     *
     * @return Tutor[]|ArrayCollection
     */
    public function getTutors()
    {
        return $this->tutors;
    }

    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    function __toString()
    {
        if ($this->organizationUnit) {
            return $this->organizationUnit . ': ' . $this->name;
        }
        return $this->name;
    }


}
