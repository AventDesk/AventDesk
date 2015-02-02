<?php

require "../vendor/autoload.php";

define("APP_PATH", __DIR__ . "/../app");
define("PUBLIC_PATH", __DIR__);

require "bootstrap.php";

$app->get("/", "Avent\\Controllers\\IndexController::index");
$app->registerEvent("Avent\\Events\\LoggerHook");
$app->run();

// EOF
