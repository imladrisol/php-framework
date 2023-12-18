<?php

declare(strict_types=1);

namespace Framework\Http;

use Framework\Http\Exceptions\HttpException;
use Framework\Routing\RouterInterface;
use League\Container\Container;

final class Kernel
{
    private string $appEnv = 'local';

    public function __construct(
        private RouterInterface $router,
        private Container $container
    )
    {
        $this->appEnv = $this->container->get('APP_ENV');
    }

    public function handle(Request $request): Response
    {
        try {
            [$routerHandler, $vars] = $this->router->dispatch($request, $this->container);

            $response = call_user_func_array($routerHandler, $vars);
        } catch (\Exception $e) {
            $response = $this->createExceptionResponse($e);
        }

        return $response;
    }

    private function createExceptionResponse(\Throwable $e)
    {
        if (in_array($this->appEnv, ['local', 'testing'])) {
            throw $e;
        }

        if ($e instanceof HttpException) {
            return new Response($e->getMessage(), $e->getStatusCode());
        }

        return new Response($e->getMessage(), 500);
    }
}
