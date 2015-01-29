<?php


namespace Avent\Core\Entity;

/**
 * Class TimestampableTrait
 * @package Avent\Core\Entity
 */
trait TimestampableTrait
{
    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    protected $created_at;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    protected $updated_at;

    /**
     * @PrePersist
     */
    public function fillTimestamp()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    /**
     * @PreUpdate
     */
    public function updateTimestamp()
    {
        $this->updated_at = new \DateTime();
    }
}

// EOF
