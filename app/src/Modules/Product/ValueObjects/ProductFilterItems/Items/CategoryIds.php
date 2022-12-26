<?php

namespace Modules\Product\ValueObjects\ProductFilterItems\Items;

use Modules\Product\ValueObjects\ProductFilterItems\AbstractCmsFilterItem;
use Modules\Product\ValueObjects\ProductFilterItems\Concerns\TermsTrait;

final class CategoryIds extends AbstractCmsFilterItem
{
    use TermsTrait;

    protected string $itemType = 'PRODUCT';

    protected string $queryField = 'categoryId';
}
