<?php

namespace Mohin\Framework\Http;


use Exception;
use Mohin\Framework\Routing\Router;
use Psr\Container\ContainerInterface;


readonly class Kernel
{
    public function __construct(private Router $router, private ContainerInterface $container)
    {
    }

    public function handle(Request $request)
    {

        try {
            [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);
            return call_user_func_array($routeHandler, $vars);
        } catch (Exception $exception) {
            return new Response($exception->getMessage(), 400);
        }
    }
}