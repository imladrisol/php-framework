<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Framework\Http\Kernel;
use Framework\Http\Request;

$request = Request::createFromGlobals();

$kernel = new Kernel();
$response = $kernel->handle($request);
$response->send();
