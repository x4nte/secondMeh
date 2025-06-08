<?php

namespace App\Kernel\Http;

abstract class Middleware
{
    public function handle(Request $request, \Closure $next){}
}