<?php

$app = new \Avent\Core\Application();

$container = $app->getContainer();

// Define Service email service and its dependency
$container->singleton("SwiftMailer", function() {
    $transport = \Swift_SmtpTransport::newInstance("localhost", 25)
        ->setUsername("username")
        ->setPassword("password");

    return Swift_Mailer::newInstance($transport);
});

$container->singleton("SwiftMessage", function() {
    return \Swift_Message::newInstance();
});

$container->singleton("Avent\\Services\\Infrastructure\\MailTemplateService");

$container->singleton("Avent\\Services\\Infrastructure\\MailerService")
    ->withArgument("SwiftMailer")
    ->withArgument("SwiftMessage")
    ->withArgument("Avent\\Services\\Infrastructure\\MailTemplateService");

// Define user registration service and its dependency
$container->singleton("HasherService", function () {
    return new \Avent\Services\Domain\HasherService();
});

$container->singleton("PersonRepository", function () use ($container) {
    return $container->get("EntityManager")->getRepository("Avent\\Repository\\PersonRepository");
});

$container->singleton("Avent\\Services\\Domain\\UserRegistrationService")
    ->withArgument("PersonRepository")
    ->withArgument("EventEmitter")
    ->withArgument("Validator")
    ->withArgument("HasherService");

// Register Command
$app->registerCommandHandler("Avent\\CommandBus\\Handler\\UserRegistrationHandler");
