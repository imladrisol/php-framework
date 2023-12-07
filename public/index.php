<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Imladrisol\Framework\Http\Request;

$request = Request::createFromGlobals();
dd($request);