<?php

namespace Modules\Product\ValueObjects\ProductFilterItems\Items;

use Modules\Product\ValueObjects\ProductFilterItems\AbstractCmsFilterItem;
use Modules\Product\ValueObjects\ProductFilterItems\Concerns\BoolTrait;
use Modules\Product\ValueObjects\ProductFilterItems\Concerns\TermsTrait;

final class IsPredicted extends AbstractCmsFilterItem
{
    use TermsTrait;
    use BoolTrait;

    protected string $itemType = 'PRODUCT';

    protected string $queryField = 'isPredicted';
}
