<?php

namespace Modules\Product\ValueObjects;

use Modules\Common\ValueObjects\AbstractValueObject;

final class WillNotUpdate extends AbstractValueObject
{
    public function __construct(
        public readonly string $command = '',
        public readonly string $property = '',
        public readonly string $reason = ''
    ) {
    }
}
