<?php

use App\Controllers\TaskController;
use App\Kernel\Router\Route;
use App\Middleware\AuthMiddleware;
use App\Middleware\LogMiddleware;

return[
    Route::get('/tasks',[TaskController::class,'index'])->middleware(LogMiddleware::class)->middleware(AuthMiddleware::class),
    Route::get('/tasks/{id}',[TaskController::class,'show'])
];