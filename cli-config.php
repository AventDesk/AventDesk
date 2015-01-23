<?php

$app = new \Avent\Core\Application();
$app->init();

$di = $app->getContainer();
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($di->get("em"));

// EOF
