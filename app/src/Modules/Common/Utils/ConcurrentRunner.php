<?php

namespace Modules\Common\Utils;

use Closure;
use Laravel\Octane\Facades\Octane;

final class ConcurrentRunner
{
    public function __invoke(Closure $closure): void
    {
        Octane::concurrently([$closure], 0);
    }
}
