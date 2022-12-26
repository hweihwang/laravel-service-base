<?php

namespace Modules\Product\Concerns;

use Modules\Product\Enums\FrontDisplay;
use Modules\Product\Enums\TenancyApp;

trait ProductSearchablePropertiesTrait
{
    public readonly int $productId;
    
    public readonly string $name;
    
    public readonly int $categoryId;
    
    public readonly int $brandId;
    
    public readonly bool $isPredicted;
    
    public readonly FrontDisplay $frontDisplay;
    
    /**
     * @var array<TenancyApp> $frontSites
     */
    public readonly array $frontSites;
}
