<?php


namespace Avent\Entity;

use Avent\Core\Entity\EntityInterface;
use Avent\Core\Entity\TimestampableTrait;
use Avent\Core\Entity\ToArrayTrait;

/**
 * @Entity(repositoryClass="Avent\Repository\ArticleRepository")
 * @Table(name="article")
 **/
class Article implements EntityInterface
{
    use ToArrayTrait;
    use TimestampableTrait;

    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    protected $article_id;

    /**
     * @ManyToOne(targetEntity="Person", inversedBy="article")
     * @JoinColumn(name="person_id", referencedColumnName="person_id")
     * @var \Avent\Entity\Person
     **/
    protected $person;

    /**
     * @Column(type="string", length=255)
     * @var string
     */
    protected $article_title;

    /**
     * @Column(type="text")
     * @var string
     */
    protected $article_body;

    /**
     * @return int
     */
    public function getArticleId()
    {
        return $this->article_id;
    }

    /**
     * @param int $article_id
     */
    public function setArticleId($article_id)
    {
        $this->article_id = $article_id;
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
    public function setPerson($person)
    {
        $this->person = $person;
    }

    /**
     * @return string
     */
    public function getArticleTitle()
    {
        return $this->article_title;
    }

    /**
     * @param string $article_title
     */
    public function setArticleTitle($article_title)
    {
        $this->article_title = $article_title;
    }

    /**
     * @return string
     */
    public function getArticleBody()
    {
        return $this->article_body;
    }

    /**
     * @param string $article_body
     */
    public function setArticleBody($article_body)
    {
        $this->article_body = $article_body;
    }
}

// EOF
