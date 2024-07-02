<?php

namespace App\Controller;

use Mohin\Framework\Http\Response;

class HomeController
{
    public function index(): Response
    {
        return new Response('<h1>Hello World!</h1>');
    }


    public function post(int $id): Response
    {
        return new Response("<h1>post id is {$id}<h1>");
    }

}