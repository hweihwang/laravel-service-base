<?php

declare(strict_types=1);

namespace Modules\Common\ValueObjects;

use BadMethodCallException;

trait ImmutableTrait
{
    final public function __get(string $name)
    {
        $function = 'get'.ucfirst($name);

        return $this->{$function}();
    }

    final public function __isset(string $name): bool
    {
        $function = 'get'.ucfirst($name);

        return method_exists($this, $function);
    }

    final public function __set($key, $value)
    {
        throw new BadMethodCallException('Immutable object cannot be mutated');
    }
}
