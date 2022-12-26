<?php

declare(strict_types=1);

namespace Modules\Common\Cache\CacheKey;

interface CacheKeyBuilderInterface
{
    public function build(string $key = '', array $parameters = []): string;
}
