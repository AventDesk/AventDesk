<?php
// Here you can initialize variables that will be available to your tests

include __DIR__ . "/../../vendor/autoload.php";

define("APP_PATH", __DIR__ . "/../../app");
define("PUBLIC_PATH", __DIR__ . "/../../public");

// Mock dependency
$repository_mock = \Codeception\Util\Stub::make("\\Avent\\Repository\\PersonRepository", [
    "save" => function () {
        return true;
    },
    "findOneBy" => function () {
        return true;
    },
    "findOneByPersonId" => function () {
        return new \Avent\Entity\Person();
    }
]);

$em_mock = \Codeception\Util\Stub::make("\\Doctrine\\ORM\\EntityManager", [
    "getRepository" => $repository_mock
]);

$event_mock = \Codeception\Util\Stub::make("\\Avent\\Core\\Event\\EventEmitter", [
    "emit" => function () {
        return true;
    }
]);

$hasher_mock = \Codeception\Util\Stub::make("\\Avent\\Services\\Domain\\HasherService", [
    "hash" => function () {
        return "12345";
    }
]);

// Create new apps
$app = new \Avent\Core\Application();

// register dependency in container
$app->getContainer()->singleton("PersonRepository", $repository_mock);
$app->getContainer()->singleton("EventEmitter", $event_mock);
$app->getContainer()->singleton("EntityManager", $em_mock);
$app->getContainer()->singleton("HasherService", $hasher_mock);
$app->getContainer()->singleton("ValidatorService", "Avent\\Services\\Domain\\ValidatorService")
    ->withArgument("Validator");

\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
    "Symfony\\Component\\Validator\\Constraint",
    __DIR__ . "/../../vendor/symfony/validator"
);

// Register user registration service in container
$app->getContainer()->singleton("Avent\\Services\\Domain\\UserRegistrationService")
    ->withArgument("PersonRepository")
    ->withArgument("EventEmitter")
    ->withArgument("ValidatorService")
    ->withArgument("HasherService");

// Register user profile service in container
$app->getContainer()->singleton("Avent\\Services\\Domain\\UserProfileService")
    ->withArgument("PersonRepository")
    ->withArgument("EventEmitter")
    ->withArgument("ValidatorService");

// Domain service factory
$app->getContainer()->singleton("DomainServicesFactory", function() use ($app) {
    return new \Avent\Services\DomainServiceFactory($app->getContainer());
});

// Infrastructire service factory
$app->getContainer()->singleton("InfrastructureServicesFactory", function () use ($app) {
    return new \Avent\Services\InfrastructureServiceFactory($app->getContainer());
});

// User registration service handler
$app->registerCommandHandler("Avent\\CommandBus\\Handler\\UserRegistrationHandler");
// StubHandler for testing command bus
$app->registerCommandHandler("Avent\\Stubs\\HandlerStub");
$app->registerCommandHandler("Avent\\CommandBus\\Handler\\UserProfileHandler");

// Save app
$app->saveApp();
