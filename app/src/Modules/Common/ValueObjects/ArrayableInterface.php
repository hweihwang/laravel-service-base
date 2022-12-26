<?php

declare(strict_types=1);

namespace Modules\Common\ValueObjects;

interface ArrayableInterface
{
//    public static function fromArray(array $data): self;

    public function toArray(): array;
}
