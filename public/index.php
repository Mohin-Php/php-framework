<?php

declare(strict_types=1);


use Mohin\Framework\Http\Kernel;
use Mohin\Framework\Routing\Router;


define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/vendor/autoload.php';
$container = require BASE_PATH . '/framework/config/service.php';


$request = \Mohin\Framework\Http\Request::createFromGlobals();

$kernel = $container->get(Kernel::class);
$response = $kernel->handle($request);
$response->send();