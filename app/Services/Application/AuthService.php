<?php


namespace Avent\Services\Application;

use Avent\Repository\PersonRepository;

/**
 * Class AuthService
 * @package Avent\Services\Domain
 */
class AuthService
{
    /**
     * @var PersonRepository
     */
    private $repository;

    /**
     * @param PersonRepository $repository
     */
    public function __construct(PersonRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public function verify($email, $password)
    {
        $person = $this->repository->findOneBy(["email" => $email]);

        if ($person == null) {
            return false;
        }

        $hash = $person->getPassword();

        if (!(password_verify($password, $hash))) {
            return false;
        }

        return true;
    }
}

// EOF
