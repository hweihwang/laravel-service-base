<?php

declare(strict_types=1);

namespace Modules\Common\Cache;

use Modules\Common\Cache\CacheKey\CacheKeyBuilderInterface;

trait CacheableTrait
{
    protected CacheProviderInterface $cacheProvider;

    protected CacheKeyBuilderInterface $cacheKeyBuilder;

    public function setCacheProvider(CacheProviderInterface $cacheProvider): self
    {
        $this->cacheProvider = $cacheProvider;

        return $this;
    }

    public function setCacheKeyBuilder(CacheKeyBuilderInterface $cacheKeyBuilder): self
    {
        $this->cacheKeyBuilder = $cacheKeyBuilder;

        return $this;
    }
}
