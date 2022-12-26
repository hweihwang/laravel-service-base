<?php

declare(strict_types=1);

namespace Modules\Common\Models;

interface StateGettableInterface
{
    public function __call(string $name, array $arguments);
}
