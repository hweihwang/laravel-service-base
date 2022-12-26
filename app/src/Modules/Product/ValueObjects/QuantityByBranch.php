<?php

namespace Modules\Product\ValueObjects;

use Modules\Common\ValueObjects\AbstractValueObject;

final class QuantityByBranch extends AbstractValueObject
{
    public function __construct(
        public readonly int $branchId,
        public readonly int $quantity,
    ) {
    }
}
