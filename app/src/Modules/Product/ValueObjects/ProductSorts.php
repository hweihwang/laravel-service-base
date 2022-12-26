<?php

namespace Modules\Product\ValueObjects;

use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\Enums\ProductSortBy;
use Modules\Product\Enums\ProductSortDirection;

final class ProductSorts extends AbstractValueObject
{
    public function __construct(
        public readonly ProductSortBy $sortBy,
        public readonly ProductSortDirection $direction
    ) {
    }
}
