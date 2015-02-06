<?php


namespace Avent\Entity;

use Avent\Core\Entity\EntityInterface;
use Avent\Core\Entity\ToArrayTrait;
use Avent\ValueObject\Address;
use Avent\ValueObject\Social;
use Avent\ValueObject\Timestamp;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="Avent\Repository\PersonRepository")
 * @Table(name="person")
 **/
class Person implements EntityInterface
{
    use ToArrayTrait;

    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    protected $person_id;

    /**
     * @Column(type="string", length=64, unique=true)
     * @var string
     */
    protected $email;

    /**
     * @Column(type="string", length=128)
     * @var string
     */
    protected $password;

    /**
     * @Column(type="string", length=64, nullable=true)
     * @var string
     */
    protected $first_name;

    /**
     * @Column(type="string", length=64, nullable=true)
     * @var string
     */
    protected $last_name;

    /**
     * @Column(type="string", length=64, nullable=true)
     * @var string
     */
    protected $phone;

    /**
     * @Column(type="string", length=128, unique=true)
     * @GeneratedValue(strategy="UUID")
     */

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
     * @ManyToOne(targetEntity="PersonGroup", inversedBy="persons")
     * @JoinColumn(name="group_id", referencedColumnName="group_id")
     * @var PersonGroup
     */
    protected $group = null;

    /**
     * @ManyToOne(targetEntity="Company", inversedBy="persons")
     * @JoinColumn(name="company_id", referencedColumnName="company_id")
     * @var Company
     */
    protected $company = null;

    /**
     * @ManyToOne(targetEntity="PersonRole", inversedBy="persons")
     * @JoinColumn(name="role_id", referencedColumnName="role_id")
     * @var PersonRole
     */
    protected $role;

    /**
     * @ManyToOne(targetEntity="Department", inversedBy="persons")
     * @JoinColumn(name="department_id", referencedColumnName="department_id")
     * @var Department
     */
    protected $department;

    /**
     * @OneToMany(targetEntity="Article", mappedBy="article_id")
     * @var ArrayCollection
     */
    protected $articles;

    /**
     * @OneToMany(targetEntity="Ticket", mappedBy="ticket_id")
     * @var ArrayCollection
     */
    protected $assigned_tickets;

    /**
     * @OneToMany(targetEntity="Ticket", mappedBy="ticket_id")
     * @var ArrayCollection
     */
    protected $opened_tickets;

    /**
     * @OneToOne(targetEntity="ApiKey", mappedBy="person")
     * @var ApiKey
     */
    protected $api_key;

    /**
     * @Embedded(class="Avent\ValueObject\Timestamp", columnPrefix=false)
     * @var Timestamp
     */
    protected $timestamp;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
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
     * @param int $person_id
     */
    public function setPersonId($person_id)
    {
        $this->person_id = $person_id;
    }

    /**
     * @return int
     */
    public function getPersonId()
    {
        return $this->person_id;
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
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param PersonGroup $group
     */
    public function setGroup(PersonGroup $group)
    {
        $group->addPerson($this);
        $this->group = $group;
    }

    /**
     * @return PersonGroup
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param Company $company
     */
    public function setCompany(Company $company)
    {
        $company->addPerson($this);
        $this->company = $company;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
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

    /**
     * @return Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param Department $department
     */
    public function setDepartment($department)
    {
        $department->addPersons($this);
        $this->department = $department;
    }

    /**
     * @return Timestamp
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param Timestamp $timestamp
     */
    public function setTimestamp(Timestamp $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return ArrayCollection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param Article $article
     */
    public function addArticle(Article $article)
    {
        $article->setAuthor($this);
        $this->articles[] = $article;
    }

    /**
     * @return ArrayCollection
     */
    public function getAssignedTickets()
    {
        return $this->assigned_tickets;
    }

    /**
     * @param Ticket $ticket
     */
    public function addAssignedTickets(Ticket $ticket)
    {
        $ticket->setAssignee($this);
        $this->assigned_tickets[] = $ticket;
    }

    /**
     * @return ArrayCollection
     */
    public function getOpenedTickets()
    {
        return $this->opened_tickets;
    }

    /**
     * @param Ticket $ticket
     */
    public function addOpenedTickets(Ticket $ticket)
    {
        $ticket->setCreator($this);
        $this->opened_tickets[] = $ticket;
    }

    /**
     * @return ApiKey
     */
    public function getApiKey()
    {
        return $this->api_key;
    }

    /**
     * @param ApiKey $api_key
     */
    public function setApiKey(ApiKey $api_key)
    {
        $this->api_key = $api_key;
    }
}

// EOF
