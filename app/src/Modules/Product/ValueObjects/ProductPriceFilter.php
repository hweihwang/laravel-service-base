<?php

namespace Modules\Product\ValueObjects;

use Modules\Common\ValueObjects\AbstractValueObject;

final class ProductPriceFilter extends AbstractValueObject
{
    public function __construct(
        public readonly ?int $min,
        public readonly ?int $max,
    ) {
    }
}
