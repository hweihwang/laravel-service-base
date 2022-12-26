<?php

declare(strict_types=1);

namespace Modules\Common\ValueObjects;

interface ValidatableInterface
{
    public function isValid(array $data = [], array $rules = []): bool;
}
