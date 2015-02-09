<?php


namespace Avent\CommandBus\Command;

use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\Repository\RepositoryAwareTrait;
use Avent\Entity\Person;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PasswordReminderCommand
 * @package Avent\CommandBus\Command
 */
class PasswordReminderCommand implements CommandInterface
{
    use RepositoryAwareTrait;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @var string
     */
    private $email;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @Assert\True(message = "The email not exist in database")
     */
    public function isEmailExist()
    {
        $person = $this->repository->findOneBy(["email" => $this->getEmail()]);

        return ($person instanceof Person) ? true : false;
    }
}

// EOF
