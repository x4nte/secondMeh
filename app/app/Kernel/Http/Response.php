<?php

namespace App\Kernel\Http;

class Response
{


    private string $content;
    private int $status;

    public function __construct(string $content, int $status = 200)
    {
        $this->content = $content;
        $this->status = $status;
    }

    public function send()
    {
        http_response_code($this->status);
        echo $this->content;
    }
}