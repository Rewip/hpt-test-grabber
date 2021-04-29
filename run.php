<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

// In production we should remove 'true' from the line beneath for performance boost
$loader = new Nette\DI\ContainerLoader(__DIR__ . '/temp', true);
$class = $loader->load(function($compiler) {
    $compiler->loadConfig(__DIR__ . '/config/config.neon');
});
$container = new $class;

$dispatcher = $container->getByType(\App\Application\ApplicationDispatcher::class);

$json = $dispatcher->run();
file_put_contents('output.json', $json);
