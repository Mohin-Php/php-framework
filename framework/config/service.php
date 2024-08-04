<?php

use League\Container\Container;
use Mohin\Framework\Http\Kernel;
use Mohin\Framework\Routing\Router;
use Mohin\Framework\Routing\RouterInterface;

$container = new Container();

$container->add(RouterInterface::class,Router::class);

$container->add(Kernel::class)->addArgument(RouterInterface::class);
return $container;