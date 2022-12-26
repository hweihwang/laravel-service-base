<?php

namespace Modules\Product\ValueObjects;

use Modules\Common\ValueObjects\AbstractValueObject;

final class FilterCanBeAbsent extends AbstractValueObject
{
    public function __construct(
        public readonly string $filterItemName = ''
    ) {
    }
}
