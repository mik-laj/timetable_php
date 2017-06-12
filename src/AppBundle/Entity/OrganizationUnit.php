<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use TimetableBundle\Entity\Field;

/**
 * OrganizationUnit
 *
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="organization_unit", indexes={
 *     @ORM\Index(name="fk_organization_unit_parent1_idx", columns={"parent_id"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrganizationUnitRepository")
 */
class OrganizationUnit
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
     * @var integer
     *
     * @Gedmo\TreeLeft
     * @ORM\Column(type="integer")
     */
    private $lft;

    /**
     * @var integer
     *
     * @Gedmo\TreeRight
     * @ORM\Column(type="integer")
     */
    private $rgt;

    /**
     * @var integer
     *
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer")
     */
    private $lvl;

    /**
     * @var OrganizationUnit
     *
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrganizationUnit", inversedBy="children")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @var ArrayCollection|OrganizationUnit[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OrganizationUnit", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var ArrayCollection|Room[] $rooms
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Room", mappedBy="organizationUnit")
     */
    private $rooms;
    /**
     * @var ArrayCollection|Field[] $fields
     *
     * @ORM\OneToMany(targetEntity="TimetableBundle\Entity\Field", mappedBy="organizationUnit")
     */
    private $fields;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
        $this->fields = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return OrganizationUnit
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
     * Get parent
     *
     * @return OrganizationUnit|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set parent
     *
     * @param OrganizationUnit|null $parent
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get left
     *
     * @return int
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Get left
     *
     * @return int
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Get level of depth
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Get children
     *
     * @return ArrayCollection | OrganizationUnit[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Get rooms
     *
     * @return ArrayCollection | Room[]
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * Add room
     *
     * @return $this
     */
    public function addRoom(Room $room) {
        if($this->rooms->contains($room)){
            return $this;
        }

        $this->rooms->add($room);
        $room->setOrganizationUnit($this);

        return $this;
    }

    /**
     * Remove room
     *
     * @return $this
     */
    public function removeRoom(Room $room) {
        if(!$this->rooms->contains($room)){
            return $this;
        }

        $this->rooms->removeElement($room);
        $room->setOrganizationUnit(null);

        return $this;
    }

    /**
     * Get fields
     *
     * @return Field[]|ArrayCollection
     */
    public function getFields()
    {
        return $this->fields;
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
