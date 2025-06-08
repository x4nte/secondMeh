<?php

namespace App\Middleware;

use App\Kernel\Http\Middleware;
use App\Kernel\Http\Request;
use App\Kernel\Http\Response;

class LogMiddleware extends Middleware
{
    public function handle(Request $request, \Closure $next) : Response
    {
        return $next($request);
    }
}