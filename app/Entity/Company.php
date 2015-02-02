<?php


namespace Avent\Entity;

use Avent\Core\Entity\EntityInterface;
use Avent\Core\Entity\ToArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Avent\ValueObject\Address;
use Avent\ValueObject\Social;

/**
 * Class Company
 * @package Avent\Entity
 * @Entity(repositoryClass="Avent\Repository\CompanyRepository")
 * @Table(name="company")
 */
class Company implements EntityInterface
{
    use ToArrayTrait;

    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    protected $company_id;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $company_name;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $phone;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $email;

    /**
     * @Embedded(class="Avent\ValueObject\Address", columnPrefix=false)
     * @var Address
     */
    protected $address;

    /**
     * @Embedded(class="Avent\ValueObject\Social", columnPrefix=false)
     * @var Social
     */
    protected $social;

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
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param string $company_name
     */
    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->getCompanyName();
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @return Social
     */
    public function getSocial()
    {
        return $this->social;
    }

    /**
     * @param Social $social
     */
    public function setSocial(Social $social)
    {
        $this->social = $social;
    }


}

// EOF
