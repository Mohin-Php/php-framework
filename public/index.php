<?php

declare(strict_types=1);


use Mohin\Framework\Http\Kernel;
use Mohin\Framework\Routing\Router;


define('BASE_PATH', dirname(__DIR__));
require_once dirname(__DIR__) . '/vendor/autoload.php';


$request = \Mohin\Framework\Http\Request::createFromGlobals();

$kernel = new Kernel(new Router());
$response = $kernel->handle($request);
$response->send();