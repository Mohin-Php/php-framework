<?php

use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Container;
use Mohin\Framework\Http\Kernel;
use Mohin\Framework\Routing\Router;
use Mohin\Framework\Routing\RouterInterface;

$routes = include BASE_PATH . '/routes/web.php';

$container = new Container();
$container->delegate(new \League\Container\ReflectionContainer(true));

$container->add(RouterInterface::class, Router::class);
$container->extend(RouterInterface::class)->addMethodCall('setRoute', [new ArrayArgument($routes)]);

$container->add(Kernel::class)->addArgument(RouterInterface::class)->addArgument($container);
return $container;