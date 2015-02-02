<?php


namespace Avent\ValueObject;

/**
 * Class Timestamp
 * @package Avent\ValueObject
 * @Embeddable
 */
class Timestamp
{
    /**
     * @Column(type="date", nullable=true)
     * @var \DateTime
     */
    protected $created_at;

    /**
     * @Column(type="date", nullable=true)
     * @var \DateTime
     */
    protected $updated_at;

    /**
     * @preUpdate
     * @return void
     */
    protected function beforeUpdate()
    {
        $this->updated_at = new \DateTime();
    }

    /**
     * @prePersist
     * @return void
     */
    protected function beforeInsert()
    {
        $this->created_at = new \DateTime();
    }
}

// EOF
