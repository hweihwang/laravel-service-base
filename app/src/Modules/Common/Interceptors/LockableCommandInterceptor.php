<?php

namespace Modules\Common\Interceptors;

use Modules\Common\Hasher\ObjectHasherInterface;
use Modules\Common\Locker\LockManagerInterface;

#[\Attribute]
final class LockableCommandInterceptor
{
    public function __construct(
        public readonly int $delayIntercept,
        public readonly LockManagerInterface $locker,
        public ObjectHasherInterface $hasher,
        public string $hashedCommand = ''
    ) {
    }
}
