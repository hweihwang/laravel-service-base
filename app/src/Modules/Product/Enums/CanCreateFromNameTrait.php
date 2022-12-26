<?php

namespace Modules\Product\Enums;

trait CanCreateFromNameTrait
{
    public static function fromName(string $name): self
    {
        foreach (self::cases() as $status) {
            if ($name === $status->name) {
                return $status;
            }
        }

        throw new \ValueError("$name is not a valid backing value for enum ".self::class);
    }
}
