<?php

declare(strict_types=1);

use Framework\Http\Kernel;
use League\Container\Container;
use Framework\Routing\RouterInterface;
use Framework\Routing\Router;

$container = new Container();
$container->add(RouterInterface::class, Router::class);
$container->add(Kernel::class)->addArgument(RouterInterface::class);

return $container;
