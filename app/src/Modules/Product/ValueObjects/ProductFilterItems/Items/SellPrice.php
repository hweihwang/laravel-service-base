<?php

namespace Modules\Product\ValueObjects\ProductFilterItems\Items;

use Modules\Product\ValueObjects\ProductFilterItems\AbstractCmsFilterItem;
use Modules\Product\ValueObjects\ProductFilterItems\Concerns\RangesTrait;

final class SellPrice extends AbstractCmsFilterItem
{
    use RangesTrait;

    protected string $itemType = 'SKU';

    protected string $queryField = 'skus.sellPrice';
}
