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
use League\Container\ContainerInterface;
use League\Route\RouteCollection;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;

class Application implements
    EventEmitterAwareInterface,
    ContainerAwareInterface,
    EntityManagerAwareInterface
{
    use EventEmitterAwareTrait;
    use ContainerAwareTrait;
    use EntityManagerAwareTrait;

    private $route;

    public function init()
    {
        $this->initService();
        $this->initEvents();
        $this->defineDependency();
        $this->initRoutes($this->getContainer());
    }

    public function run()
    {
        $this->getContainer()->get("event")->emit("before.app");

        // run app here
        $dispatcher = $this->route->getDispatcher();

        $dispatcher->dispatch("GET", "/")->send();

        $this->getContainer()->get("event")->emit("after.app");
    }

    protected function initRoutes(ContainerInterface $container)
    {
        $route = new RouteCollection($container);

        // define route here
        $route->addRoute('GET', '/', 'Avent\\Controllers\\IndexController::index');
        $this->route = $route;
    }

    protected function initEvents()
    {
        $emitter = new EventEmitter();

        $events_dir = APP_PATH . "/Events";

        foreach (glob("{$events_dir}/*Hook.php") as $file) {
            list($class_name) = explode(".", $file);
            $class_name = "Avent\\Events\\" . $class_name;

            $listener = new $class_name();

            $emitter->addListener($listener->getEventName(), $listener);
        }

        $this->setEventEmitter($emitter);

        // add event to container
        $this->container->add("event", $this->getEventEmitter());
    }

    protected function initService()
    {
        $container = new Container();

        // add config to container
        $config = (object) include APP_PATH . "/Config/Config.php";
        $container->add("config", $config);

        // add entity manager to container
        $container->add("em", function() use ($container) {
            $entity_path = [APP_PATH . "/Entity"];
            $isDev = $container->get("config")->application["dev"];
            $db_config = $container->get("config")->database;

            $db_conn =  Setup::createAnnotationMetadataConfiguration($entity_path, $isDev);

            return EntityManager::create($db_config, $db_conn);
        });

        // add logger to container
        $container->add("logger", function() use ($container) {
            $config = $container->get("config")->logger;

            $formatter = new LineFormatter($config["format"], $config["date_format"]);
            $log_level = $config["log_level"];
            $logger = new Logger("Avent");

            foreach ($config["handlers"] as $handler) {
                $handler = HandlerCreator::$handler["name"]($formatter, $handler, $log_level);
                $logger->pushHandler($handler);
            }

            return $logger;
        });

        // add http request to container
        $request = new Request();
        $request->createFromGlobals();
        $container->add("Symfony\\Component\\HttpFoundation\\Request", $request);

        // add http response to container
        $container->add("Symfony\\Component\\HttpFoundation\\Response");


        $this->setContainer($container);
    }

    protected function defineDependency()
    {
        $this->injectControllerDependency();

        // define custom class dependency here
    }

    protected function injectControllerDependency()
    {
        $controller_dir = APP_PATH . "/Controllers";

        $files = array_diff(scandir($controller_dir), array('..', '.'));

        foreach ($files as $file) {
            list($class_name) = explode(".", $file);
            $class_name = "Avent\\Controllers\\" . $class_name;
            $this->getContainer()->add($class_name)
                ->withMethodCall("setConfig", ["config"])
                ->withMethodCall("setEntityManager", ["em"])
                ->withMethodCall("setLogger", ["logger"])
                ->withMethodCall("setEventEmitter", ["event"]);
        }

    }
}

// EOF
