<?php

namespace Modules\Product\Enums;

enum ProductSortBy: string
{
    use CanCreateFromNameTrait;
    use HasPropertyTrait;
    
    case PRODUCT_ID = 'PRODUCT_ID';
    
    public function property(): string
    {
        return match ($this) {
            self::PRODUCT_ID => 'productId'
        };
    }
}
