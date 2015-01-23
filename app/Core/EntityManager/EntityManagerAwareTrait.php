<?php


namespace Avent\Core\EntityManager;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class EntityManagerAwareTrait
 * @package Avent\Core\EntityManager
 */
trait EntityManagerAwareTrait
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function setEntityManager(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager()
    {
        return $this->em;
    }
}

// EOF
