<?php

namespace Modules\Product\Entities;

use JeroenG\Explorer\Application\Explored;
use JeroenG\Explorer\Application\SearchableFields;
use Modules\Common\Models\CollectableInterface;
use Modules\Common\Models\CollectForSearchTrait;
use Modules\Common\Models\StateGettableInterface;
use Modules\Common\Models\StateGettableTrait;
use Modules\Common\ValueObjects\ArrayableInterface;
use Modules\Common\ValueObjects\ArrayableTrait;
use Modules\Common\ValueObjects\ValidatableInterface;
use Modules\Common\ValueObjects\ValidatableTrait;
use Modules\Product\Concerns\ProductCanSearchTrait;
use Modules\Product\Concerns\ProductSearchablePropertiesTrait;
use Modules\Product\Enums\FrontDisplay;

final class SearchableProduct implements ValidatableInterface, ArrayableInterface, Explored, SearchableFields,
                                         CollectableInterface, StateGettableInterface
{
    use ProductCanSearchTrait;
    use ProductSearchablePropertiesTrait;
    use CollectForSearchTrait;
    use ValidatableTrait;
    use StateGettableTrait;
    use ArrayableTrait;
    
    public static function fromArray(array $data): self
    {
        $static = new self();
        
        $static->productId = $data['productId'];
        $static->name = $data['name'];
        $static->categoryId = $data['categoryId'];
        $static->brandId = $data['brandId'];
        $static->isPredicted = $data['isPredicted'];
        $static->frontDisplay = FrontDisplay::fromName($data['frontDisplay']);
        
        return $static;
    }
    
    public function toArray(): array
    {
        return [
            'productId' => $this->productId,
            'name' => $this->name,
            'categoryId' => $this->categoryId,
            'brandId' => $this->brandId,
            'isPredicted' => $this->isPredicted,
            'frontDisplay' => $this->frontDisplay->name,
        ];
    }
}
