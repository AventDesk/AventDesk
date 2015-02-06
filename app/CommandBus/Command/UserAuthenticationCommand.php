<?php


namespace Avent\CommandBus\Command;

use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\Repository\RepositoryAwareTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserAuthenticationCommand
 * @package Avent\CommandBus\Command
 */
class UserAuthenticationCommand implements CommandInterface
{
    use RepositoryAwareTrait;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @var string
     */
    private $email;

    /**
     * @Assert\NotBlank
     * @var string
     */
    private $password;

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
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}

// EOF
