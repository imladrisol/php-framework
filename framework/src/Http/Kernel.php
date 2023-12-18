<?php

declare(strict_types=1);

namespace Framework\Http;

use Framework\Http\Exceptions\HttpException;
use Framework\Routing\RouterInterface;
use League\Container\Container;

final class Kernel
{
    public function __construct(
        private RouterInterface $router,
        private Container $container
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            [$routerHandler, $vars] = $this->router->dispatch($request, $this->container);

            $response = call_user_func_array($routerHandler, $vars);
        } catch (HttpException $e) {
            $response = new Response($e->getMessage(), $e->getStatusCode());
        } catch (\Throwable $e) {
            $response = new Response($e->getMessage(), 500);
        }

        return $response;
    }
}
