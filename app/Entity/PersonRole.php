<?php


namespace Avent\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class PersonRole
 * @package Avent\Entity
 * @Entity(repositoryClass="Avent\Repository\PersonRoleRepository")
 * @Table(name="person_role")
 */
class PersonRole
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    protected $role_id;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $role_name;

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
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * @return string
     */
    public function getRoleName()
    {
        return $this->role_name;
    }

    /**
     * @param string $role_name
     */
    public function setRoleName($role_name)
    {
        $this->role_name = $role_name;
    }

    /**
     * @return ArrayCollection
     */
    public function getPersons()
    {
        return $this->persons;
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
