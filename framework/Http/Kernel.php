<?php

declare(strict_types=1);

namespace Framework\Http;

use FastRoute\RouteCollector;

use function FastRoute\simpleDispatcher;

final class Kernel
{
    public function handle(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $routes = include BASE_PATH . '/routes/web.php';
            foreach ($routes as $route) {
                $collector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());
        [$status, [$controller, $action], $vars] = $routeInfo;

        return call_user_func_array([new $controller(), $action], $vars);
    }
}
