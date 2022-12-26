<?php

namespace Modules\Product\ValueObjects\ProductFilterItems\Items;

use Modules\Product\ValueObjects\ProductFilterItems\AbstractCmsFilterItem;
use Modules\Product\ValueObjects\ProductFilterItems\Concerns\TermsTrait;

final class BrandIds extends AbstractCmsFilterItem
{
    use TermsTrait;

    protected string $itemType = 'PRODUCT';

    protected string $queryField = 'brandId';
}
