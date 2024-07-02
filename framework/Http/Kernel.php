<?php

namespace Mohin\Framework\Http;

use Exception;
use Mohin\Framework\Routing\Router;


readonly class Kernel
{
    public function __construct(private Router $router)
    {
    }

    public function handle(Request $request)
    {

        try {
            [$routeHandler, $vars] = $this->router->dispatch($request);
            return call_user_func_array($routeHandler, $vars);
        } catch (Exception $exception) {
            return new Response($exception->getMessage(), 400);
        }
    }
}