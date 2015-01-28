<?php


namespace Avent\Core\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Interface RepositoryAwareInterface
 * @package Avent\Core\Repository
 */
interface RepositoryAwareInterface
{
    /**
     * @param EntityRepository $repository
     * @return void
     */
    public function setRepository(EntityRepository $repository);

    /**
     * @return EntityRepository
     */
    public function getRepository();
}

// EOF
