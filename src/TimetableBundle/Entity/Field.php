<?php

namespace TimetableBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Field
 *
 * @ORM\Table(name="field", indexes={
 *     @ORM\Index(name="fk_field_tutor1_idx", columns={"tutor_id"}),
 *     @ORM\Index(name="fk_field_organization_unit1_idx", columns={"organization_unit_id"})
 * })
 * @ORM\Entity(repositoryClass="TimetableBundle\Repository\FieldRepository")
 */
class Field
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
     * @var string
     *
     * @ORM\Column(name="mode", type="string", length=45, nullable=false)
     */
    private $mode;

    /**
     * @var \AppBundle\Entity\Tutor
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tutor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tutor_id", referencedColumnName="id")
     * })
     */
    private $tutor;

    /**
     * @var string
     *
     * @ORM\Column(name="semester", type="integer")
     * @Assert\Expression(
     *     "value >= 1 && (this.getNumberOfSemester() == false || this.getNumberOfSemester() >= value)",
     *     message="Invalid semestr value"
     * )
     */
    private $semester;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_of_semester", type="integer", nullable=true)
     */
    private $number_of_semester;

    /**
     * @var \AppBundle\Entity\OrganizationUnit
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrganizationUnit", inversedBy="fields")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="organization_unit_id", referencedColumnName="id")
     * })
     */
    private $organizationUnit;


    /**
     * @var ArrayCollection|StudentGroup[] $studentGroups
     *
     * @ORM\OneToMany(targetEntity="TimetableBundle\Entity\StudentGroup", mappedBy="field")
     */
    private $studentGroups;


    public function __construct()
    {
        $this->studentGroups = new ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Field
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
     * Set mode
     *
     * @param string $mode
     *
     * @return Field
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Get tutor
     *
     * @return Tutor
     */
    public function getTutor()
    {
        return $this->tutor;
    }

    /**
     * Set tutor
     *
     * @param Tutor $tutor
     * @return Field
     */
    public function setTutor($tutor)
    {
        $this->tutor = $tutor;
        return $this;
    }

    /**
     * Get semester
     *
     * @return string
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * Set semester
     *
     * @param string $semester
     * @return Field
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;
        return $this;
    }

    /**
     * Get number Of Semester
     *
     * @return int
     */
    public function getNumberOfSemester()
    {
        return $this->number_of_semester;
    }

    /**
     * Set number of semester
     * @param int $number_of_semester
     * @return Field
     */
    public function setNumberOfSemester($number_of_semester)
    {
        $this->number_of_semester = $number_of_semester;
        return $this;
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
     * @return Field
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
     * Get student groups
     *
     * @return Room[]|ArrayCollection
     */
    public function getStudentGroups()
    {
        return $this->studentGroups;
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
