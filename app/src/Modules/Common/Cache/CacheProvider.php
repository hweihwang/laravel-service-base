<?php

declare(strict_types=1);

namespace Modules\Common\Cache;

use Modules\Common\Repositories\KeyValueRepository\KeyValueRepositoryInterface;
use Psr\SimpleCache\InvalidArgumentException;

final class CacheProvider implements CacheProviderInterface
{
    protected KeyValueRepositoryInterface $repository;

    public function __construct(KeyValueRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function remember(string $key, callable $callback, float $minutes = 5)
    {
        $store = $this->repository->getStore();

        $cachedValue = $store->get($key);

        if (! is_null($cachedValue)) {
            return $cachedValue;
        }

        $value = $callback();

        //Don't use queue here, because queue workers run in separate processes and can not access the octane cache
        //If you want to use queue, you need to use another cache provider (redis, memcached, etc.)
        //Changing the cache provider by switch KeyValueRepositoryInterface implementation in the container, or simply pass to the constructor
        $store->put($key, $value, $minutes * 60);

        return $value;
    }
}
