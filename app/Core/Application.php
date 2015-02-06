<?php


namespace Avent\Core;

use Avent\Core\EntityManager\EntityManagerAwareInterface;
use Avent\Core\EntityManager\EntityManagerAwareTrait;
use Avent\Core\Event\EventEmitter;
use Avent\Core\Event\EventEmitterAwareInterface;
use Avent\Core\Event\EventEmitterAwareTrait;
use Avent\Core\Logger\HandlerCreator;
use Avent\Response\ApiResponse;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use League\Container\Container;
use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use League\Route\RouteCollection;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

class Application implements
    EventEmitterAwareInterface,
    ContainerAwareInterface,
    EntityManagerAwareInterface
{
    use EventEmitterAwareTrait;
    use ContainerAwareTrait;
    use EntityManagerAwareTrait;

    public $routes = [];

    private static $instance;

    public function __construct()
    {
        $this->setContainer(new Container());
        $this->setEventEmitter(new EventEmitter());
        $this->initService();
    }

    public function saveApp()
    {
        self::$instance = $this;
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    protected function addRoute($method, $uri, $callback, $level = 0)
    {
        if (($callback instanceof \Closure)) {
            $this->routes[] = [$method, $uri, $callback, $level];
        } else {
            $this->routes[] = [$method, $uri, $callback, $level];
            list($class_name) = explode("::", $callback);
            $this->getContainer()->singleton($class_name)
                ->withArguments(["EventEmitter", "CommandBus"]);
        }
    }

    public function post($uri, $callback, $level = 0)
    {
        $this->addRoute("POST", $uri, $callback, $level);
    }

    public function get($uri, $callback, $level = 0)
    {
        $this->addRoute("GET", $uri, $callback, $level);
    }

    public function put($uri, $callback, $level = 0)
    {
        $this->addRoute("PUT", $uri, $callback, $level);
    }

    public function delete($uri, $callback, $level = 0)
    {
        $this->addRoute("DELETE", $uri, $callback, $level);
    }

    public function registerEvent($listener, $arguments = ["Logger"], $priority = EventEmitter::P_NORMAL)
    {
        $this->container->singleton($listener)
            ->withArguments($arguments);
        $this->getEventEmitter()->addListener(
            $listener::getEventName(),
            $listener,
            $priority
        );
    }

    public function registerService($alias, $callback)
    {
        $this->getContainer()->add($alias, $callback);
    }

    public function registerCommandHandler($handler)
    {
        $this->container->singleton($handler)
            ->withArgument("DomainServicesFactory")
            ->withArgument("InfrastructureServicesFactory");
    }

    public function run()
    {
        $this->getEventEmitter()->setContainer($this->getContainer());
        if ($this->getEventEmitter()->emit(EventEmitter::AFTER_APP)->isPropagationStopped()) {
            throw new \RuntimeException("Application cancelled by domain events");
        }

        $router = new RouteCollection($this->getContainer());

        foreach ($this->routes as $route) {
            $router->addRoute($route[0], $route[1], $route[2]);
        }

        $dispatcher = $router->getDispatcher();

        if ($this->getEventEmitter()->emit(EventEmitter::BEFORE_DISPATCH)->isPropagationStopped()) {
            throw new \RuntimeException("Application cancelled by domain events");
        }

        if ($this->getEventEmitter()->emit("security.event")->isPropagationStopped()) {
            throw new \DomainException("Your access token not sufficient to access this method");
        }

        $response = $dispatcher->dispatch(strtoupper($_SERVER["REQUEST_METHOD"]), $_SERVER["REQUEST_URI"]);

        $this->getEventEmitter()->emit(EventEmitter::AFTER_DISPATCH);

        $response->send();

        $this->getEventEmitter()->emit(EventEmitter::AFTER_APP);
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
