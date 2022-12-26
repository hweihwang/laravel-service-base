<?php

namespace Modules\Common\Interceptors;

use Throwable;

#[\Attribute]
final class TransactionableCommandInterceptor
{
    public function __construct(public readonly Throwable $exception)
    {
    }
}
