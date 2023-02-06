<?php

namespace Frameworks\Laravel\Middlewares;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

final class VerifyCsrfToken extends Middleware
{
    protected $except = [];
}
