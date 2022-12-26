<?php

declare(strict_types=1);

namespace Modules\Common\Models;

trait StateGettableTrait
{
    public function __call(string $name, array $arguments)
    {
        if (preg_match('/^get(.+)$/', $name, $matches)) {
            $property = lcfirst($matches[1]);
            if (property_exists($this, $property)) {
                return $this->{$property};
            }
        }
        throw new \BadMethodCallException("Method {$name} does not exist.");
    }
}
