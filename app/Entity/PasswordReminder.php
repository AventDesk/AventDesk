<?php


namespace Avent\Entity;

use Avent\Core\Entity\ToArrayTrait;
use Avent\ValueObject\Timestamp;

/**
 * Class PasswordReminder
 * @package Avent\Entity
 * @Entity(repositoryClass="Avent\Repository\PasswordRemainderRepository")
 * @Table(name="password_reminder")
 */
class PasswordReminder
{
    use ToArrayTrait;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $remainder_id;

    /**
     * @Column(type="string", length=128)
     * @GeneratedValue(strategy="UUID")
     * @var string
     */
    protected $code;

    /**
     * @ManyToOne(targetEntity="Person", inversedBy="password_remainders")
     * @JoinColumn(name="person_id", referencedColumnName="person_id")
     * @var Person
     */
    protected $person;


    /**
     * @Column(type="boolean")
     * @var bool
     */
    protected $is_active;

    /**
     * @Embedded(class="Avent\ValueObject\Timestamp", columnPrefix=false)
     * @var Timestamp
     */
    protected $timestamp;

    /**
     * @return int
     */
    public function getRemainderId()
    {
        return $this->remainder_id;
    }

    /**
     * @param int $remainder_id
     */
    public function setRemainderId($remainder_id)
    {
        $this->remainder_id = $remainder_id;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param Person $person
     */
    public function setPerson(Person $person)
    {
        $this->person = $person;
    }

    /**
     * @return boolean
     */
    public function isIsActive()
    {
        return $this->is_active;
    }

    /**
     * @param boolean $is_active
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
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
}

// EOF
