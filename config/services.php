<?php

declare(strict_types=1);

use Framework\Http\Kernel;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Container;
use Framework\Routing\RouterInterface;
use Framework\Routing\Router;
use League\Container\ReflectionContainer;
use Symfony\Component\Dotenv\Dotenv;

$routes = include BASE_PATH . '/routes/web.php';

$dotenv = new Dotenv();
$dotenv->load(BASE_PATH . '/.env');

$container = new Container();
$container->delegate(new ReflectionContainer(true));
$appEnv = $_ENV['APP_ENV'] ?? 'local';
$container->add('APP_ENV', $appEnv);
$container->add(RouterInterface::class, Router::class);
$container->extend(RouterInterface::class)
    ->addMethodCall('registerRoutes', [new ArrayArgument($routes)]);

$container->add(Kernel::class)
    ->addArgument(RouterInterface::class)
    ->addArgument($container);

return $container;
