<?php

define("APP_PATH", __DIR__ . "/app");

$app = new \Avent\Core\Application();

$di = $app->getContainer();
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($di->get("EntityManager"));

// EOF
