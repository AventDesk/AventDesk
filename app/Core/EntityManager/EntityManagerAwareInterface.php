<?php


namespace Avent\Core\EntityManager;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Interface EntityManagerAwareInterface
 * @package Avent\Core\EntityManager
 */
interface EntityManagerAwareInterface
{
    /**
     * @param EntityManagerInterface $em
     * @return void
     */
    public function setEntityManager(EntityManagerInterface $em);

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager();
}

// EOF
