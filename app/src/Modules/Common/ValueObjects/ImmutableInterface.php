<?php

declare(strict_types=1);

namespace Modules\Common\ValueObjects;

interface ImmutableInterface
{
    public function __get(string $name);

    public function __isset(string $name): bool;

    public function __set($key, $value);
}
