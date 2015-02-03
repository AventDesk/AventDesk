<?php


namespace Avent\ValueObject;

use Avent\Core\ValueObject\ValueObjectInterface;

/**
 * Class Address
 * @package Avent\ValueObject
 * @Embeddable
 */
class Address implements ValueObjectInterface
{
    /**
     * @Column(type="string", length=128, nullable=true)
     * @var string
     */
    public $street;

    /**
     * @Column(type="string", length=64, nullable=true)
     * @var string
     */
    public $city;

    /**
     * @Column(type="string", length=32, nullable=true)
     * @var string
     */
    public $zip_code;

    /**
     * @Column(type="string", length=64, nullable=true)
     * @var string
     */
    public $state;

    /**
     * @Column(type="string", length=64, nullable=true)
     * @var string
     */
    public $country;

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }

    /**
     * @param string $zip_code
     */
    public function setZipCode($zip_code)
    {
        $this->zip_code = $zip_code;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }


}

// EOF
