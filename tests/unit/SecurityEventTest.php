<?php

class SecurityEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Avent\Core\Application
     */
    private $app;

    private $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJwZXJzb25faWQiOjEsImFwaV9rZXkiOiIxMjM0NTY3OCIsImxldmVsIjo0fQ.N7mJkc1o2reHEUf-pPLCjzwOBsE2P7uirmF5VXpPGek";

    public function setUp()
    {
        $this->app = \Avent\Core\Application::getInstance();

        $this->app->get(
            "/hello-world",
            function () {
                return "Hello World";
            },
            5
        );

        $this->app->getContainer()->singleton("JwtService", function () {
            return new \Avent\Services\Application\JwtService("secret");
        });
        $this->app->getContainer()->singleton("Logger", function () {
            return new \Monolog\Logger("test");
        });

        $this->app->registerEvent(
            "\\Avent\\Events\\SecurityHook",
            [
                "Logger",
                "JwtService"
            ]
        );

        $this->app->getEventEmitter()->setContainer($this->app->getContainer());
    }

    public function tearDown()
    {

    }

    public function testSecurityEvent()
    {
        $data = [
            "token" => $this->token,
            "request_uri" => "/hello-world",
            "method" => "GET",
        ];

        $event = $this->app->getEventEmitter()->emit("security.event", $data, (array) $this->app->routes);

        $this->assertTrue($event->isPropagationStopped());
    }
}

// EOF
