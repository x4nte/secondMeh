<?php

namespace App\Kernel\Router;

class Route
{

    private array $middlewares = [];

    public function __construct(private string $uri, private string $method, private mixed $action)
    {

    }

    public static function get(string $uri, mixed $action): self
    {
        return new self($uri, 'GET', $action);
    }

    public static function post(string $uri, mixed $action): self
    {
        return new self($uri, 'POST', $action);
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getAction(): mixed
    {
        return $this->action;
    }

    public function middleware($middleware) : self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function getMiddlewares() : array
    {
        return $this->middlewares;
    }
}