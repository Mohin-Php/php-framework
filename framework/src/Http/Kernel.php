<?php

namespace Mohin\Framework\Http;


use Exception;
use Mohin\Framework\Routing\Router;
use Psr\Container\ContainerInterface;


readonly class Kernel
{
    private string $appEnv;
    public function __construct(private Router $router, private ContainerInterface $container)
    {
        $this->appEnv = $this->container->get('APP_ENV');

    }

    public function handle(Request $request)
    {

        try {
            throw new Exception('1');
            [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);
            $response = call_user_func_array($routeHandler, $vars);
        } catch (Exception $exception) {
            $response = $this->createExceptionResponse($exception);
        }
        return $response;
    }
    /**
     * @throws  \Exception $exception
     */
    private function createExceptionResponse(\Exception $exception): Response
    {
        if (in_array($this->appEnv, ['dev', 'test'])) {
            throw $exception;
        }

        if ($exception instanceof HttpException) {
            return new Response($exception->getMessage(), $exception->getStatusCode());
        }

        return new Response('Server error', Response::HTTP_INTERNAL_SERVER_ERROR);
    }


}