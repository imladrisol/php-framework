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
        [$handler, $vars] = $this->extractRouteInfo($request);

        if (is_array($handler)) {
            [$controller, $action] = $handler;
            $handler = [new $controller(), $action];
        }

        return [$handler, $vars];
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
                $e = new RouteNotFoundException('Route not found');
                $e->setStatusCode(404);
                throw $e;
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowMethods = implode(',', $routeInfo[1]);
                $message = 'Method is not allowed. Please, use one of these: ' . $allowMethods;
                $e = new MethodIsNotAllowedException($message);
                $e->setStatusCode(405);
                throw $e;
        }
    }
}