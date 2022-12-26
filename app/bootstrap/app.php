<?php

use Frameworks\Laravel\Application;
use Frameworks\Laravel\ConsoleKernel;
use Frameworks\Laravel\ExceptionHandler;
use Frameworks\Laravel\HttpKernel;

$app = new Application($_ENV['APP_BASE_PATH'] ?? dirname(__DIR__));

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    HttpKernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    ConsoleKernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    ExceptionHandler::class
);

return $app;
