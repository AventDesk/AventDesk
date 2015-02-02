<?php


namespace Avent\Entity;

use Avent\Core\Entity\EntityInterface;
use Avent\Core\Entity\ToArrayTrait;
use Avent\ValueObject\Timestamp;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Article
 * @package Avent\Entity
 * @Entity(repositoryClass="Avent\Repository\ArticleRepository")
 * @Table(name="article")
 */
class Article implements EntityInterface
{
    use ToArrayTrait;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $article_id;

    /**
     * @Column(type="string", length=128)
     * @var string
     */
    protected $article_title;

    /**
     * @Column(type="text")
     * @var string
     */
    protected $article_body;

    /**
     * @ManyToOne(targetEntity="Person", inversedBy="articles")
     * @JoinColumn(name="person_id", referencedColumnName="person_id")
     * @var Person
     */
    protected $author;

    /**
     * @ManyToMany(targetEntity="Tag", inversedBy="articles")
     * @JoinTable(name="article_tags",
     *      joinColumns={@JoinColumn(name="article_id", referencedColumnName="article_id")},
     *      inverseJoinColumns={@JoinColumn(name="tag_id", referencedColumnName="tag_id")}
     * )
     * @var ArrayCollection
     */
    protected $tags;

    /**
     * @Embedded(class="Avent\ValueObject\Timestamp", columnPrefix=false)
     * @var Timestamp
     */
    protected $timestamp;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

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
     * @return Person
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param Person $author
     */
    public function setAuthor(Person $author)
    {
        $this->author = $author;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $tag->addArticle($this);
        $this->tags[] = $tag;
    }
}

// EOF
