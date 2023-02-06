<?php

declare(strict_types=1);

namespace Modules\Common\Cache\CacheKey;

use JsonException;

final class JsonEncodeCacheKeyBuilder implements CacheKeyBuilderInterface
{
    /**
     * @throws JsonException
     */
    public function build(string $key = '', array $parameters = []): string
    {
        return $key.':'.json_encode($parameters, JSON_THROW_ON_ERROR);
    }
}
