<?php


namespace Avent\Repository;

use Avent\Entity\PasswordReminder;
use Doctrine\ORM\EntityRepository;

/**
 * Class PasswordReminderRepository
 * @package Avent\Repository
 */
class PasswordReminderRepository extends EntityRepository
{
    /**
     * @param PasswordReminder $password_reminder
     */
    public function save(PasswordReminder $password_reminder)
    {
        $this->_em->persist($password_reminder);
        $this->_em->flush();
    }
}

// EOF
