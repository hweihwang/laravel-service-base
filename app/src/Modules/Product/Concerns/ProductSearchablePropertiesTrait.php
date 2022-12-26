<?php

namespace Modules\Product\Concerns;

use Modules\Product\Enums\FrontDisplay;

trait ProductSearchablePropertiesTrait
{
    public readonly int $productId;
    
    public readonly string $name;
    
    public readonly int $categoryId;
    
    public readonly int $brandId;
    
    public readonly bool $isPredicted;
    
    public readonly FrontDisplay $frontDisplay;
}
