<?php


namespace Avent\CommandBus\Command;

use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\Repository\RepositoryAwareTrait;
use Avent\ValueObject\Address;
use Avent\ValueObject\Social;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CompanyCreatorCommand
 * @package Avent\CommandBus\Command
 */
class CompanyCreatorCommand implements CommandInterface
{
    use RepositoryAwareTrait;

    /**
     * @var int
     */
    private $company_id;

    /**
     * @Assert\NotBlank
     * @var string
     */
    private $company_name;

    /**
     * @Assert\NotBlank
     * @var string
     */
    private $company_phone;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @var string
     */
    private $email;

    /**
     * @var Address
     */
    private $address;

    /**
     * @var Social
     */
    private $social;

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param int $company_id
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * @param string $company_name
     */
    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;
    }

    /**
     * @return string
     */
    public function getCompanyPhone()
    {
        return $this->company_phone;
    }

    /**
     * @param string $company_phone
     */
    public function setCompanyPhone($company_phone)
    {
        $this->company_phone = $company_phone;
    }

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
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @return Social
     */
    public function getSocial()
    {
        return $this->social;
    }

    /**
     * @param Social $social
     */
    public function setSocial(Social $social)
    {
        $this->social = $social;
    }
}

// EOF
