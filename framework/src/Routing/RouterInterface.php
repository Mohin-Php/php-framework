<?php

namespace Mohin\Framework\Routing;


use Mohin\Framework\Http\Request;
use Psr\Container\ContainerInterface;

interface RouterInterface
{
    public function dispatch(Request $request, ContainerInterface $container): array;

    public function setRoute(array $route): void;
}