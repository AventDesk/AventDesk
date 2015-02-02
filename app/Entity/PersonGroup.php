<?php


namespace Avent\Entity;

use Avent\Core\Entity\EntityInterface;
use Avent\Core\Entity\ToArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class PersonGroup
 * @package Avent\Entity
 * @Entity(repositoryClass="Avent\Repository\PersonGroupRepository")
 * @Table(name="person_group")
 */
class PersonGroup implements EntityInterface
{
    use ToArrayTrait;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    protected $group_id;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $group_name;

    /**
     * @OneToMany(targetEntity="Person", mappedBy="person_id")
     * @var ArrayCollection
     */
    protected $persons = null;

    public function __construct()
    {
        $this->persons = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * @param $group_name
     */
    public function setGroupName($group_name)
    {
        $this->group_name = $group_name;
    }

    /**
     * @return string
     */
    public function getGroupName()
    {
        return $this->group_name;
    }

    /**
     * @param Person $person
     */
    public function addPerson(Person $person)
    {
        $this->persons[] = $person;
    }
}
// EOF
