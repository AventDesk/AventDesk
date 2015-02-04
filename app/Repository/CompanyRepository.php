<?php


namespace Avent\Repository;

use Avent\Entity\Company;
use Doctrine\ORM\EntityRepository;

/**
 * Class CompanyRepository
 * @package Avent\Repository
 */
class CompanyRepository extends EntityRepository
{
    /**
     * @param Company $company
     */
    public function save(Company $company)
    {
        $this->_em->persist($company);
        $this->_em->flush();
    }
}

// EOF
