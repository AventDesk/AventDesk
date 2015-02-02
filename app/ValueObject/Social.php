<?php


namespace Avent\ValueObject;

/**
 * Class Social
 * @package Avent\ValueObject
 * @Embeddable
 */
class Social
{
    /**
     * @Column(type="string", length=64, nullable=true)
     * @var string
     */
    protected $facebook;

    /**
     * @Column(type="string", length=64, nullable=true)
     * @var string
     */
    protected $twitter;

    /**
     * @Column(type="string", length=64, nullable=true)
     * @var string
     */
    protected $website;

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
