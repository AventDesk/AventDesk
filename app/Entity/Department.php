<?php


namespace Avent\Entity;

use Avent\Core\Entity\EntityInterface;
use Avent\Core\Entity\ToArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Department
 * @package Avent\Entity
 * @Entity(repositoryClass="Avent\Repository\DepartmentRepository")
 * @Table(name="department")
 */
class Department implements EntityInterface
{
    use ToArrayTrait;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedVaslue
     * @var string
     */
    protected $department_id;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $department_name;

    /**
     * @OneToMany(targetEntity="Person", mappedBy="person_id")
     * @var ArrayCollection
     */
    protected $persons;

    public function __construct()
    {
        $this->persons[] = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getDepartmentId()
    {
        return $this->department_id;
    }

    /**
     * @return string
     */
    public function getDepartmentName()
    {
        return $this->department_name;
    }

    /**
     * @param string $department_name
     */
    public function setDepartmentName($department_name)
    {
        $this->department_name = $department_name;
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
    public function addPersons(Person $person)
    {
        $this->persons = $person;
    }
}

// EOF
