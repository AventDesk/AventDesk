<?php


namespace Avent\Controllers;

use Avent\Core\Controller\ControllerAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends ControllerAbstract
{
    public function index(Request $request, Response $response)
    {
        $response->setContent("World");

        return $response;
    }
}

// EOF
