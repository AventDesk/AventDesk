<?php


namespace Avent\Entity;

use Avent\Core\Entity\EntityInterface;
use Avent\Core\Entity\ToArrayTrait;

/**
 * Class ApiKey
 * @package Avent\Entity
 * @Entity(repositoryClass="ApiKeyRepository")
 * @Table(name="api_key")
 */
class ApiKey implements EntityInterface
{
    use ToArrayTrait;

    /**
     * @Id
     * @Column(type="string", length=128)
     * @GeneratedValue(strategy="UUID")
     * @var string
     */
    protected $api_key;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $level;

    /**
     * @OneToOne(targetEntity="Person", inversedBy="api_key")
     * @JoinColumn(name="person_id", referencedColumnName="person_id")
     * @var Person
     */
    protected $person;

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->api_key;
    }

    /**
     * @param string $api_key
     */
    public function setApiKey($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
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
}

// EOF
