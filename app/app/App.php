<?php
namespace App;

use App\Kernel\Http\Request;
use App\Kernel\Http\Response;
use App\Kernel\Router\Router;

class App
{

    public function __construct(private Router $router)
    {
    }

    public function run(Request $request): Response
    {
        return $this->router->handle($request);
    }
}