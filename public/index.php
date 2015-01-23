<?php

require "../vendor/autoload.php";

define("APP_PATH", __DIR__ . "/../app");
define("PUBLIC_PATH", __DIR__);

$app = new \Avent\Core\Application();

$app->init();
$app->run();
