<?php
use App\App;
use App\Kernel\Container\Container;
use App\Kernel\Http\Request;


const APP_PATH = __DIR__ . '/../';
require APP_PATH . 'vendor/autoload.php';
require APP_PATH . 'app/helpers.php';
require APP_PATH . 'app/bootstrap.php';

$container = Container::getInstance();

$app = $container->get(App::class);

$request = Request::capture();
$response = $app->run($request);
$response->send();