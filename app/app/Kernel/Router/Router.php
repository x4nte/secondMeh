<?php

namespace App\Kernel\Router;


use App\Kernel\Container\Container;
use App\Kernel\Http\MiddlewareQueue;
use App\Kernel\Http\Request;
use App\Kernel\Http\Response;
use ReflectionClass;

class Router
{
    private array $routes = [];
    private Container $container;

    public function __construct()
    {
        $this->container = Container::getInstance();
        $this->initRoutes();
    }

    public function handle(Request $request): Response
    {
        $route = $this->findRoute($request->method(), $request->uri());

        if ($route) {

            $binds = $route['binds'];

            if (is_array($route['route']->getAction())) {

                [$controller, $action] = $route['route']->getAction();
                $reflection = new ReflectionClass($controller);
                $method = $reflection->getMethod($action);
                $middlewareQueue = new MiddlewareQueue();

                foreach ($route['route']->getMiddlewares() as $middleware) {
                    $middlewareQueue->add($this->container->get($middleware));
                }

                $depsForMethod = [];
                foreach ($method->getParameters() as $param)
                {

                    if (isset($binds[$param->getName()])) {
                        $depsForMethod[] = $binds[$param->getName()];
                    } else {
                        $depsForMethod[] = $this->container->get($param->getType()->getName());
                    }
                }

                $constructor = $reflection->getConstructor();
                $depsForConstructor = [];

                if ($constructor) {
                    $params = $constructor->getParameters();
                    foreach ($params as $param) {
                        $depsForConstructor[] = $this->container->get($param->getType()->getName());
                    }
                }
                $instance = $reflection->newInstanceArgs($depsForConstructor);
                $final = function (Request $request) use ($action, $instance, $depsForMethod) {
                    return $instance->$action(...$depsForMethod);
                };
                return $middlewareQueue->handle($request, $final);
            }
        }

        return new Response("Page not found", 404);
    }

    public function findRoute(string $method, string $uri): array|false
    {
        $uriExploded = explode("/", $uri);
        $pattern = "/[{}]/";
        $binds = [];
        foreach ($this->routes[$method] as $route) {
            $routeExploded = explode("/", $route->getUri());
            if (count($uriExploded) == count($routeExploded)) {
                foreach ($routeExploded as $index => $routeExplodedIndex) {
                    $uriExplodedIndex = $uriExploded[$index];
                    if ($routeExplodedIndex == $uriExplodedIndex) {
                        continue;
                    }

                    if (preg_match($pattern, $routeExplodedIndex)) {
                        $routeExplodedIndex = preg_replace($pattern, "", $routeExplodedIndex);
                        $binds[$routeExplodedIndex] = $uriExplodedIndex;
                        continue;
                    }

                    continue 2;
                }
                return ['binds' => $binds, 'route' => $route];
            }
        }
        return false;

    }


    public function initRoutes()
    {
        $routes = $this->getRoutes();
        foreach ($routes as $route) {
            $this->routes[$route->getMethod()][$route->getUri()] = $route;
        }
    }

    public function getRoutes()
    {
        return require APP_PATH . 'config/routes.php';
    }


}