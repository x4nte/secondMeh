<?php

const APP_PATH = __DIR__ . '/../../';
require APP_PATH . 'vendor/autoload.php';
require APP_PATH . 'app/helpers.php';
require APP_PATH . 'app/bootstrap.php';


use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('users', function ($table) {
    $table->increments('id');
    $table->string('email')->unique();
    $table->string('password');
    $table->timestamps();
});