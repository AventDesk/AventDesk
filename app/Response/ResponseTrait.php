<?php


namespace Avent\Response;

use League\Fractal\Manager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Class ResponseTrait
 * @package Avent\Response
 */
trait ResponseTrait
{
    /**
     * @var string
     */
    protected $json_content;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @param array $array
     * @param array $headers
     * @return $this
     */
    public function withArray(array $array, array $headers = [])
    {
        $this->response = new Response();
        $this->json_content = json_encode($array);

        if (!empty($headers)) {
            $this->setHeaders($headers);
        }

        return $this;
    }

    public function withValidationError(array $array, ConstraintViolationList $violations, array $headers = [])
    {
        $this->response = new Response();

        foreach ($violations as $violation) {
            $array["validator"][] = [
                "field" => $violation->getPropertyPath(),
                "value" => $violation->getInvalidValue(),
                "message" => $violation->getMessage()
            ];
        }

        if (!empty($headers)) {
            $this->setHeaders($headers);
        }

        $this->json_content = json_encode($array);

        return $this;
    }

    public function send($http_code = Response::HTTP_OK)
    {
        $this->response->setStatusCode($http_code);
        $this->response->setContent($this->json_content);

        return $this->response;
    }

    protected function setHeaders(array $headers)
    {
        foreach ($headers as $key => $value) {
            $this->response->headers->set($key, $value);
        }
    }

    /**
     * @return $this
     */
    public static function create()
    {
        $manager = new Manager();

        return new self($manager);
    }
}
