<?php

namespace Tests\Unit;

use Illuminate\Contracts\Cache\Repository;
use Modules\Common\Cache\CacheProvider;
use Modules\Common\Repositories\KeyValueRepository\KeyValueRepositoryInterface;
use PHPUnit\Framework\TestCase;

final class CacheProviderTest extends TestCase
{
    private Repository $store;

    private KeyValueRepositoryInterface $repository;

    private CacheProvider $cacheProvider;

    private const KEY = 'test';

    private const VALUE = 'test';

    private const NEW_VALUE = 'new_test';

    private const MINUTES = 0.1;

    protected function setUp(): void
    {
        parent::setUp();

        $this->store = $this->createMock(Repository::class);

        $this->store->method('get')
            ->with($this::KEY)
            ->willReturn($this::VALUE);

        $this->repository = $this->createMock(KeyValueRepositoryInterface::class);

        $this->repository->method('getStore')
            ->willReturn($this->store);

        $this->cacheProvider = new CacheProvider($this->repository);
    }

    public function testRememberCorrectly(): void
    {
        $this->assertEquals(
            $this::VALUE,
            $this->cacheProvider->remember($this::KEY, fn () => $this::NEW_VALUE, $this::MINUTES)
        );
    }

    public function testRememberCorrectlySecondTime(): void
    {
        $this->assertEquals(
            $this::VALUE,
            $this->cacheProvider->remember($this::KEY, fn () => $this::NEW_VALUE, $this::MINUTES)
        );
    }

    private function testExpiredCache(): void
    {
        $this->store->method('get')
            ->with($this::KEY)
            ->willReturn(null);

        $this->assertNotEquals(
            $this::VALUE,
            $this->cacheProvider->remember($this::KEY, fn () => $this::NEW_VALUE, $this::MINUTES)
        );
    }
}
