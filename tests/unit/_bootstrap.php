<?php
// Here you can initialize variables that will be available to your tests

include __DIR__ . "/../../vendor/autoload.php";

define("APP_PATH", __DIR__ . "/../../app");
define("PUBLIC_PATH", __DIR__ . "/../../public");

// Create new apps
$app = new \Avent\Core\Application();

// register dependency in container
$app->getContainer()->singleton("ValidatorService", "Avent\\Services\\Application\\ValidatorService")
    ->withArgument("Validator");

\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
    "Symfony\\Component\\Validator\\Constraint",
    __DIR__ . "/../../vendor/symfony/validator"
);


// Domain service factory
$app->getContainer()->singleton("DomainServicesFactory", function() use ($app) {
    return new \Avent\Services\DomainServiceFactory($app->getContainer());
});

// Infrastructire service factory
$app->getContainer()->singleton("InfrastructureServicesFactory", function () use ($app) {
    return new \Avent\Services\InfrastructureServiceFactory($app->getContainer());
});

// Save app
$app->saveApp();
