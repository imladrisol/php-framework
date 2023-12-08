<?php

declare(strict_types=1);

namespace Framework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Framework\Http\Exceptions\MethodIsNotAllowedException;
use Framework\Http\Exceptions\RouteNotFoundException;
use Framework\Http\Request;
use function FastRoute\simpleDispatcher;

final class Router implements RouterInterface
{
    public function dispatch(Request $request): array
    {
        [[$controller, $action], $vars] = $this->extractRouteInfo($request);

        return [[new $controller(), $action], $vars];
    }

    /**
     * @param Request $request
     * @return array
     * @throws MethodIsNotAllowedException
     * @throws RouteNotFoundException
     */
    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $routes = include BASE_PATH . '/routes/web.php';
            foreach ($routes as $route) {
                $collector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                throw new RouteNotFoundException('Route not found');
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowMethods = implode(',', $routeInfo[1]);
                $message = 'Method is not allowed. PLease, use one of these: ' . $allowMethods;
                throw new MethodIsNotAllowedException($message);
        }
    }
}