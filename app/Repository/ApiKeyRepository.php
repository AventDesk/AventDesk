<?php


namespace Avent\Repository;

use Avent\Entity\ApiKey;
use Doctrine\ORM\EntityRepository;

/**
 * Class ApiKeyRepository
 * @package Avent\Repository
 */
class ApiKeyRepository extends EntityRepository
{
    /**
     * @param ApiKey $api_key
     */
    public function save(ApiKey $api_key)
    {
        $this->_em->persist($api_key);
        $this->_em->flush();
    }
}

// EOF
