<?php

class SecurityEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Avent\Core\Application
     */
    private $app;

    public function setUp()
    {
        $this->app = \Avent\Core\Application::getInstance();

        $repository_mock = \Codeception\Util\Stub::make(
            "\\Avent\\Repository\\ApiKeyRepository",
            [
                "findOneBy" => function() {
                    $key = new \Avent\Entity\ApiKey();
                    $key->setApiKey("123");
                    $key->setLevel(9);
                    return $key;
                }
            ]
        );


        $this->app->get(
            "/hello-world",
            function () {
                return "Hello World";
            },
            5
        );

        $this->app->getContainer()->singleton("ApiKeyRepository", $repository_mock);
        $this->app->getContainer()->singleton("Logger", function () {
            return new \Monolog\Logger("test");
        });

        $this->app->registerEvent(
            "\\Avent\\Events\\SecurityHook",
            [
                "Logger",
                "ApiKeyRepository"
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
            "api_key" => 123,
            "request_uri" => "/hello-world",
            "method" => "GET",
        ];

        $event = $this->app->getEventEmitter()->emit("before.dispatch", $data, (array) $this->app->routes);

        if ($event->isPropagationStopped()) {
            $this->fail();
        }
    }
}

// EOF
