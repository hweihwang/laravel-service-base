<?php

namespace Tests\Unit;

use Modules\Common\Cache\CacheKey\CacheKeyBuilderInterface;
use Modules\Common\Cache\CacheKey\JsonEncodeCacheKeyBuilder;
use PHPUnit\Framework\TestCase;

final class CacheKeyBuilderTest extends TestCase
{
    private CacheKeyBuilderInterface $cacheKeyBuilder;

    private const KEY = 'test';

    private const PARAMETERS = [
        'test' => 'test',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->cacheKeyBuilder = new JsonEncodeCacheKeyBuilder();
    }

    public function testBuildRunningCorrectly(): void
    {
        $this->assertEquals('test:{"test":"test"}', $this->cacheKeyBuilder->build($this::KEY, $this::PARAMETERS));
    }
}
