<?php

namespace App\Controllers;

use App\Kernel\Http\Request;
use App\Kernel\Http\Response;
use App\Kernel\View\View;

class UserController extends Controller
{
    public function login(Request $request)
    {
        return new Response($this->twig->render('index.html.twig'), 200);
    }

    public function show(Request $request, $id) : Response
    {
        return new Response("123123");
    }
}