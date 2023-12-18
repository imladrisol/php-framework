<link rel="icon" href="data:;base64,=">
<?php
define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/config/services.php';

use Framework\Http\Kernel;
use Framework\Http\Request;
use League\Container\Container;

$request = Request::createFromGlobals();

/** @var Container $container */
$container = require BASE_PATH . '/config/services.php';

/** @var Kernel $kernel */
$kernel = $container->get(Kernel::class);

$response = $kernel->handle($request);
$response->send();
