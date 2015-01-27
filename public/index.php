<?php

require "../vendor/autoload.php";

define("APP_PATH", __DIR__ . "/../app");
define("PUBLIC_PATH", __DIR__);

$app = new \Avent\Core\Application();

$app->get("/", "Avent\\Controllers\\IndexController::index");
$app->registerEvent("Avent\\Events\\LoggerHook");
$app->run();
