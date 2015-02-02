<?php


namespace Avent\Response;

/**
 * Interface ResponseInterface
 * @package Avent\Response
 */
interface ResponseInterface
{
    /**
     * @param $http_code
     * @return \\Symfony\\Component\\HttpFoundation\\Response
     */
    public function send($http_code);
}

// EOF
