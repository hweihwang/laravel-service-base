<?php

declare(strict_types=1);

namespace Frameworks\Laravel;

use Illuminate\Foundation\Application as LaravelApplication;

final class Application extends LaravelApplication
{
    /**
     * {@inheritdoc}
     */
    public function path($path = ''): string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Modules'.
            DIRECTORY_SEPARATOR.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function configPath($path = ''): string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'config'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function databasePath($path = ''): string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'frameworks'.DIRECTORY_SEPARATOR.'Laravel'.
            DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function langPath($path = ''): string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'frameworks'.DIRECTORY_SEPARATOR.'Laravel'.
            DIRECTORY_SEPARATOR.'Languages'.DIRECTORY_SEPARATOR.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}
