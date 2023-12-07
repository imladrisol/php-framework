<?php

declare(strict_types=1);

namespace Imladrisol\Framework\Http;

final class Kernel
{
    public function handle(Request $request): Response
    {
        $content = '<h1>Hello, World</h1>';

        return new Response($content, 200);
    }
}
