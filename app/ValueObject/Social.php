<?php


namespace Avent\ValueObject;

use Avent\Core\ValueObject\ValueObjectInterface;

/**
 * Class Social
 * @package Avent\ValueObject
 * @Embeddable
 */
class Social implements ValueObjectInterface
{
    /**
     * @Column(type="string", length=64, nullable=true)
     * @var string
     */
    public $facebook;

    /**
     * @Column(type="string", length=64, nullable=true)
     * @var string
     */
    public $twitter;

    /**
     * @Column(type="string", length=64, nullable=true)
     * @var string
     */
    public $website;

    /**
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param string $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param string $twitter
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }
}

// EOF
