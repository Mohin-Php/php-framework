<?php

declare(strict_types=1);

use Mohin\Framework\Http\Kernel;
use Mohin\Framework\Http\Request;

define('BASE_PATH', dirname(__DIR__));
require_once dirname(__DIR__) . '/vendor/autoload.php';


$request = Request::createFromGlobals();

$kernel = new Kernel(new \Mohin\Framework\Routing\Router());
$response = $kernel->handle($request);
$response->send();