<?php


namespace Avent\Entity;

use Avent\Core\Entity\EntityInterface;
use Avent\Core\Entity\ToArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Tag
 * @package Avent\Entity
 * @Entity(repositoryClass="Avent\Repository\TagRepository")
 * @Table(name="tag")
 */
class Tag implements EntityInterface
{
    use ToArrayTrait;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $tag_id;

    /**
     * @ManyToMany(targetEntity="Article", mappedBy="tags")
     * @var ArrayCollection
     */
    protected $articles;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $tag_name;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getTagId()
    {
        return $this->tag_id;
    }

    /**
     * @param int $tag_id
     */
    public function setTagId($tag_id)
    {
        $this->tag_id = $tag_id;
    }

    /**
     * @return Article
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param Article $articles
     */
    public function addArticle(Article $articles)
    {
        $this->articles[] = $articles;
    }

    /**
     * @return string
     */
    public function getTagName()
    {
        return $this->tag_name;
    }

    /**
     * @param string $tag_name
     */
    public function setTagName($tag_name)
    {
        $this->tag_name = $tag_name;
    }
}

// EOF
