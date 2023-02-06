<?php

declare(strict_types=1);

namespace Frameworks\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Common\Cache\CacheKey\CacheKeyBuilderInterface;
use Modules\Common\Cache\CacheKey\JsonEncodeCacheKeyBuilder;
use Modules\Common\Cache\CacheProvider;
use Modules\Common\Cache\CacheProviderInterface;
use Modules\Common\Cache\ChainCacheProvider;
use Modules\Common\Cache\NullCacheProvider;
use Modules\Common\Hasher\ObjectHasherInterface;
use Modules\Common\Hasher\Sha256ObjectHasher;
use Modules\Common\Locker\LockManager;
use Modules\Common\Locker\LockManagerInterface;
use Modules\Common\Repositories\KeyValueRepository\KeyValueRepositoryInterface;
use Modules\Common\Repositories\KeyValueRepository\SwooleTableRepository;
use Modules\Common\Services\Session\QueryBuilderSession;
use Modules\Common\Services\Session\TransactionalSessionInterface;
use Modules\Common\Transports\API\Paging\LengthAwarePaging;
use Modules\Common\Transports\API\Paging\PagingInterface;
use Modules\Common\Transports\API\Response\ErrorResponseInterface;
use Modules\Common\Transports\API\Response\SuccessResponseInterface;
use Modules\Common\Transports\API\Response\SymphonyJsonErrorResponse;
use Modules\Common\Transports\API\Response\SymphonyJsonSuccessResponse;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->register(ModuleServiceProvider::class);

        $this->app->singleton(TransactionalSessionInterface::class, QueryBuilderSession::class);

        $this->app->singleton(PagingInterface::class, LengthAwarePaging::class);

        $this->app->singleton(SuccessResponseInterface::class, SymphonyJsonSuccessResponse::class);

        $this->app->singleton(ErrorResponseInterface::class, SymphonyJsonErrorResponse::class);

        $this->app->singleton(KeyValueRepositoryInterface::class, SwooleTableRepository::class);

        $this->app->singleton(ChainCacheProvider::class, fn () => new ChainCacheProvider([
            $this->app->make(CacheProvider::class),
            new NullCacheProvider(),
        ]));

        $this->app->singleton(CacheKeyBuilderInterface::class, JsonEncodeCacheKeyBuilder::class);

        $this->app->singleton(CacheProviderInterface::class, ChainCacheProvider::class);

        $this->app->singleton(LockManagerInterface::class, LockManager::class);

        $this->app->singleton(ObjectHasherInterface::class, Sha256ObjectHasher::class);
    }

    public function boot(): void
    {
    }
}
