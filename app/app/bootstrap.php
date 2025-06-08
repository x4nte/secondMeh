<?php

use App\Kernel\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Twig\Environment;

$container = Container::getInstance();

$container->bind(Environment::class, function (Container $container) {
    $loader = new \Twig\Loader\FilesystemLoader(APP_PATH . 'views/');
    return new \Twig\Environment($loader, [
        'cache' => false,
    ]);
});

$capsule = new Capsule;


$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => APP_PATH . '../data/database.sqlite',
    'prefix'=>''
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

