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
            $collector->addRoute('GET', '/', function () {
                $content = '<h1>Hello, World</h1>';

                return new Response($content);
            });

            $collector->get('/posts/{id:\d+}', function (array $vars) {
                $content =  "<v1>Post - {$vars['id']}</v1>";

                return new Response($content);
            });
        });

        $routeInfo = $dispatcher->dispatch($request->server['REQUEST_METHOD'], $request->server['REQUEST_URI']);
        [$status, $handler, $vars] = $routeInfo;

        return $handler($vars);
    }
}
