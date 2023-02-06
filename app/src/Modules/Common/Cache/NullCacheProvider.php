<?php

declare(strict_types=1);

namespace Modules\Common\Cache;

final class NullCacheProvider implements CacheProviderInterface
{
    public function remember(string $key, callable $callback, float $minutes = 5)
    {
        return $callback();
    }
}
