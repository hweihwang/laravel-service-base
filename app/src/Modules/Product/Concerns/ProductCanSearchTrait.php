<?php

namespace Modules\Product\Concerns;

use Laravel\Scout\Searchable;
use Modules\Common\Models\CollectForSearchTrait;

trait ProductCanSearchTrait
{
    use Searchable;
    use CollectForSearchTrait;

    public function searchableAs(): string
    {
        return 'products_cms';
    }

    public function getSearchableFields(): array
    {
        return [
            'name',
            'skus.SKU',
            'skus.MPN',
            'skus.modelName',
            'skus.specs',
        ];
    }

    public function toSearchableArray(): array
    {
        return $this->toArray();
    }

    final public function mappableAs(): array
    {
        return [];
    }

    final public function getScoutKey(): int
    {
        return $this->productId;
    }
}
