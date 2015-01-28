<?php


namespace Avent\Repository;

use Avent\Entity\Person;
use Doctrine\ORM\EntityRepository;

class PersonRepository extends EntityRepository
{
    public function save(Person $person)
    {
        $this->_em->persist($person);
        $this->_em->flush();
    }
}

// EOF
