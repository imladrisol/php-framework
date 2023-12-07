<?php

declare(strict_types=1);

namespace Framework\Http;

final class Request
{
    public function __construct(
        private readonly array $getParams,
        private readonly array $postData,
        private readonly array $cookies,
        private readonly array $files,
        private readonly array $server,
    ) {

    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getPath(): string
    {
        $urlData = parse_url($this->server['REQUEST_URI']);

        return $urlData['path'];
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }
}
