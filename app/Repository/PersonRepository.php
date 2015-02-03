<?php


namespace Avent\Repository;

use Avent\Entity\Person;
use Doctrine\ORM\EntityRepository;

/**
 * Class PersonRepository
 * @package Avent\Repository
 */
class PersonRepository extends EntityRepository
{
    /**
     * @param Person $person
     */
    public function save(Person $person)
    {
        $this->_em->persist($person);
        $this->_em->flush();
    }

    /**
     * @param $person_id
     * @return Person|null
     */
    public function findOneByPersonId($person_id)
    {
        return $this->findOneBy(["person_id" => (int) $person_id]);
    }
}

// EOF
