<?php


namespace Avent\Services\Application;

use Avent\Core\CommandBus\CommandInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ValidatorService
 * @package Avent\Services\Domain
 */
class ValidatorService
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param CommandInterface $command
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface|false
     */
    public function validate(CommandInterface $command)
    {
        $violation = $this->validator->validate($command);

        if (count($violation) > 0) {
            return $violation;
        }

        return false;
    }
}

// EOF
