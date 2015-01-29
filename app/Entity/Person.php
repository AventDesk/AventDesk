<?php


namespace Avent\Entity;

use Avent\Core\Entity\EntityInterface;
use Avent\Core\Entity\ToArrayTrait;
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
     * @OneToMany(targetEntity="Article", mappedBy="person")
     * @var \Doctrine\Common\Collections\ArrayCollection
     **/
    protected $article = null;

    public function __construct()
    {
        $this->article = new ArrayCollection();
    }

    /**
     * @param Article $article
     */
    public function addArticle(Article $article)
    {
        $this->article[] = $article;
    }

    /**
     * @return ArrayCollection
     */
    public function getArticles()
    {
        return $this->article;
    }

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
