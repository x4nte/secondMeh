<?php

namespace App\Controllers;

use Twig\Environment;

abstract class Controller
{
    public function __construct(protected Environment $twig)
    {
    }
}