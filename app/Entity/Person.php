<?php


namespace Avent\Entity;

use Avent\Core\Entity\ToArrayTrait;

/**
 * @Entity(repositoryClass="Avent\Repository\PersonRepository")
 * @Table(name="person")
 **/
class Person
{
    use ToArrayTrait;
    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    protected $person_id;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $email;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $password;

    /**
     * @return int
     */
    public function getPersonId()
    {
        return $this->person_id;
    }

    /**
     * @param int $person_id
     */
    public function setPersonId($person_id)
    {
        $this->person_id = $person_id;
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
}

// EOF
