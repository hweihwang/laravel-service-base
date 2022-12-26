<?php

namespace Modules\Common\Locker;

use Illuminate\Support\Facades\Cache;

final class LockManager implements LockManagerInterface
{
    public function lock(string $key, int $lockTime = 10): void
    {
        Cache::put($key, time(), $lockTime);
    }

    public function unlock(string $key): void
    {
        Cache::forget($key);
    }

    public function isLocked(string $key): bool
    {
        return Cache::has($key);
    }
}
