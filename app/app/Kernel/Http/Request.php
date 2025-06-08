<?php

namespace App\Kernel\Http;

class Request
{
    public readonly array $server;
    public readonly array $get;
    public readonly array $post;
    public readonly array $cookies;
    public readonly array $files;


    public function __construct()
    {
        $this->createFromGlobals();
    }

    public function createFromGlobals() : void
    {
        $this->server = $_SERVER;
        $this->get = $_GET;
        $this->post = $_POST;
        $this->cookies = $_COOKIE;
        $this->files = $_FILES;
    }

    public static function capture()
    {
        return new self();
    }

    public function uri() : string
    {
        return parse_url($this->server['REQUEST_URI'], PHP_URL_PATH);
    }

    public function method() : string
    {
        return $this->server['REQUEST_METHOD'];
    }
}