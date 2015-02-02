<?php

require_once "vendor/autoload.php";

define("APP_PATH", __DIR__ . "/app");

\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
    "Avent\\ValueObject",
    [APP_PATH . "/ValueObject"]
);
$app = new \Avent\Core\Application();

$di = $app->getContainer();
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($di->get("EntityManager"));

// EOF
