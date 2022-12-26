<?php

declare(strict_types=1);

namespace Modules\Common\Cache;

use Modules\Common\Cache\CacheKey\CacheKeyBuilderInterface;

interface CacheableInterface
{
    public function setCacheProvider(CacheProviderInterface $cacheProvider): self;

    public function setCacheKeyBuilder(CacheKeyBuilderInterface $cacheKeyBuilder): self;
}
