<?php


namespace Avent\Core;

use Avent\Core\EntityManager\EntityManagerAwareInterface;
use Avent\Core\EntityManager\EntityManagerAwareTrait;
use Avent\Core\Event\EventEmitter;
use Avent\Core\Event\EventEmitterAwareInterface;
use Avent\Core\Event\EventEmitterAwareTrait;
use Avent\Core\Logger\HandlerCreator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use League\Container\Container;
use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use League\Route\RouteCollection;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;

class Application implements
    EventEmitterAwareInterface,
    ContainerAwareInterface,
    EntityManagerAwareInterface
{
    use EventEmitterAwareTrait;
    use ContainerAwareTrait;
    use EntityManagerAwareTrait;

    private $routes = [];

    public function __construct()
    {
        $this->setContainer(new Container());
        $this->setEventEmitter(new EventEmitter());
        $this->initService();
    }

    protected function addRoute($method, $uri, $callback)
    {
        if (($callback instanceof \Closure)) {
            $this->routes[] = [$method, $uri, serialize($callback)];
        } else {
            $this->routes[] = [$method, $uri, $callback];
            list($class_name) = explode("::", $callback);
            $this->getContainer()->add($class_name)
                ->withArguments(["EntityManager", "EventEmitter"]);
        }
    }

    public function post($uri, $callback)
    {
        $this->addRoute("POST", $uri, $callback);
    }

    public function get($uri, $callback)
    {
        $this->addRoute("GET", $uri, $callback);
    }

    public function put($uri, $callback)
    {
        $this->addRoute("PUT", $uri, $callback);
    }

    public function delete($uri, $callback)
    {
        $this->addRoute("DELETE", $uri, $callback);
    }

    public function registerEvent($listener, $priority = EventEmitter::P_NORMAL)
    {
        $this->container->singleton($listener)
            ->withArguments(["Logger"]);
        $this->getEventEmitter()->addListener(
            $listener::getEventName(),
            function ($event) use ($listener) {
                 return $this->container->get($listener)->handle($event);
            },
            $priority
        );
    }

    public function registerService($alias, $callback)
    {
        $this->getContainer()->add($alias, $callback);
    }

    public function run()
    {
        $this->getEventEmitter()->setContainer($this->getContainer());
        $this->getEventEmitter()->emit("before.app");

        $router = new RouteCollection($this->getContainer());

        foreach ($this->routes as $route) {
            $router->addRoute($route[0], $route[1], $route[2]);
        }

        $dispatcher = $router->getDispatcher();

        $this->getEventEmitter()->emit("before.dispatch");

        $response = $dispatcher->dispatch(strtoupper($_SERVER["REQUEST_METHOD"]), $_SERVER["REQUEST_URI"]);

        $this->getEventEmitter()->emit("after.dispatch");

        $response->send();

        $this->getEventEmitter()->emit("after.app");
    }

    protected function initService()
    {
        // add config to container
        $config = (object)include APP_PATH . "/Config/Config.php";

        define("BASE_URL", $config->application["base_url"]);

        // add entity manager to container
        $this->getContainer()->singleton("EntityManager", function () use ($config) {
            $entity_path = [APP_PATH . "/Entity"];
            $isDev = $config->application["dev"];
            $db_config = $config->database;

            $db_conn = Setup::createAnnotationMetadataConfiguration($entity_path, $isDev);

            return EntityManager::create($db_config, $db_conn);
        });

        // add logger to container
        $this->getContainer()->singleton("Logger", function () use ($config) {
            $config = $config->logger;

            $formatter = new LineFormatter($config["format"], $config["date_format"]);
            $log_level = $config["log_level"];
            $logger = new Logger("Avent");

            foreach ($config["handlers"] as $handler) {
                $handler = HandlerCreator::$handler["name"]($formatter, $handler, $log_level);
                $logger->pushHandler($handler);
            }

            return $logger;
        });

        $this->getContainer()->singleton("Symfony\\Component\\HttpFoundation\\Request", function () {
            $request = Request::createFromGlobals();
            $request->overrideGlobals();
            return $request;
        });

        $this->getContainer()->singleton("Validator", function () {
            return Validation::createValidatorBuilder()
                ->enableAnnotationMapping()
                ->getValidator();
        });

        $this->getContainer()->singleton("EventEmitter", $this->getEventEmitter());
    }
}

// EOF
