<?php

declare(strict_types=1);

namespace Modules\Common\Cache;

use Modules\Common\Exceptions\Reporters\ExceptionReporter;
use Throwable;

final class ChainCacheProvider implements CacheProviderInterface
{
    protected array $providers = [];

    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    public function remember(string $key, callable $callback, float $minutes = 5)
    {
        foreach ($this->providers as $provider) {
            try {
                $results = $provider->remember($key, $callback, $minutes);

                if (null === $results) {
                    continue;
                }

                return $results;
            } catch (Throwable $e) {
                (new ExceptionReporter())->report($e);

                continue;
            }
        }

        return $callback();
    }
}
