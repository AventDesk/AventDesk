<?php


namespace Avent\CommandBus\Command;

use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\Repository\RepositoryAwareTrait;

use Avent\Entity\Person;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationCommand implements CommandInterface
{
    use RepositoryAwareTrait;

    /**
     * @Assert\Email
     * @Assert\NotBlank
     * @var string
     */
    protected $email;

    /**
     * @Assert\NotBlank
     * @var string
     */
    protected $password;

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

    /**
     * @Assert\True(message = "The email has been registered")
     */
    public function isEmailExist()
    {
        $person = $this->repository->findOneBy(["email" => $this->getEmail()]);

        return ($person instanceof Person) ? true : false;
    }
}

// EOF
