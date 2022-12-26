<?php

namespace Modules\Common\Locker;

interface LockManagerInterface
{
    public function lock(string $key, int $lockTime): void;

    public function unlock(string $key): void;

    public function isLocked(string $key): bool;
}
