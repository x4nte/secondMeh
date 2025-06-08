<?php

namespace App\Middleware;

use App\Kernel\Http\Middleware;
use App\Kernel\Http\Request;
use App\Kernel\Http\Response;

class AuthMiddleware extends Middleware
{
    public function handle(Request $request, \Closure $next)
    {
        return $next($request);
    }
}