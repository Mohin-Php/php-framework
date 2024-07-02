<?php

namespace Mohin\Framework\Routing;

use FastRoute\Dispatcher;
use Mohin\Framework\Http\HttpException;
use Mohin\Framework\Http\HttpRequestMethodException;
use Mohin\Framework\Http\Request;
use function FastRoute\simpleDispatcher;
use FastRoute\RouteCollector;

class Router implements RouterInterface
{


    /**
     * @throws HttpException
     */
    public function dispatch(Request $request): array
    {
        $routeInfo = $this->extractRouteInfo($request);
        [$handler, $vars] = $routeInfo;
        [$controller, $method] = $handler;
        return [[new $controller, $method], $vars];
    }

    private function extractRouteInfo(Request $request)
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $r) {
            $routes = include BASE_PATH . '/routes/web.php';
            foreach ($routes as $route) {
                $r->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());


        switch ($routeInfo[0]) {
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(',', $routeInfo[1]);
                throw new HttpRequestMethodException("The allowed methods are $allowedMethods");
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
            default:
                throw new HttpException('Route Not Found');
        }
    }
}