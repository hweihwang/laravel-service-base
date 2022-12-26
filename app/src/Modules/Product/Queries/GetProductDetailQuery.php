<?php

namespace Modules\Product\Queries;

use Modules\Common\ValueObjects\AbstractValueObject;

final class GetProductDetailQuery extends AbstractValueObject
{
    public function __construct(public readonly int $productId)
    {
    }
}
