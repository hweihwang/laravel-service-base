<?php

declare(strict_types=1);

namespace Modules\Common\Cache;

interface CacheProviderInterface
{
    public function remember(string $key, callable $callback, int $minutes = 5);
}
