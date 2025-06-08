<?php

namespace App\Kernel\Http;

class MiddlewareQueue
{
    private array $middlewares = [] ;

    public function add($middleware) : self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function handle($request, \Closure $final) : Response
    {
        $next = $final;
        foreach (array_reverse($this->middlewares) as $middleware) {
            $next = fn (Request $req) => $middleware->handle($req, $next);
        }
        return $next($request);
    }
}