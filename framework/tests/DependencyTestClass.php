<?php

declare(strict_types=1);

namespace Framework\Tests;

class DependencyTestClass
{
    public function __construct(
        private readonly Youtube $youtube,
        private readonly Telegram $telega
    ){

    }

    /**
     * @return Youtube
     */
    public function getYoutube(): Youtube
    {
        return $this->youtube;
    }

    /**
     * @return Telegram
     */
    public function getTelega(): Telegram
    {
        return $this->telega;
    }
}
