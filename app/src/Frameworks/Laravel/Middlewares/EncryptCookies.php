<?php

namespace Frameworks\Laravel\Middlewares;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

final class EncryptCookies extends Middleware
{
    protected $except = [];
}
