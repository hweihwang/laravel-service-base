<?php

namespace Modules\Product\ValueObjects;

use Modules\Common\ValueObjects\AbstractValueObject;

final class ProductPaging extends AbstractValueObject
{
    public function __construct(
        public readonly int $currentPage,
        public readonly int $perPage,
    ) {
    }
}
