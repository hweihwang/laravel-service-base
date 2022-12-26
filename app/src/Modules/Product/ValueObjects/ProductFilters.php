<?php

namespace Modules\Product\ValueObjects;

use Modules\Common\Filters\AbstractElasticSearchFilter;
use Modules\Common\Filters\FullTextSearchFilterInterface;
use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\ValueObjects\ProductFilterItems\Items\BrandIds;
use Modules\Product\ValueObjects\ProductFilterItems\Items\CategoryIds;
use Modules\Product\ValueObjects\ProductFilterItems\Items\FrontDisplay;
use Modules\Product\ValueObjects\ProductFilterItems\Items\IsPredicted;
use Modules\Product\ValueObjects\ProductFilterItems\Items\OnBiz;

final class ProductFilters extends AbstractValueObject
{
    public readonly array|FilterCanBeAbsent $frontDisplay;

    public readonly array|FilterCanBeAbsent $onBiz;

    public readonly bool|FilterCanBeAbsent $isPredicted;
    public readonly array|FilterCanBeAbsent $categoryIds;

    public readonly array|FilterCanBeAbsent $brandIds;

    public static function fromArray(array $data): self
    {
        $static = new self();

        $static->frontDisplay = $data['frontDisplay'] ?? new FilterCanBeAbsent('frontDisplay');
        $static->onBiz = $data['onBiz'] ?? new FilterCanBeAbsent('onBiz');
        $static->isPredicted = $data['isPredicted'] ?? new FilterCanBeAbsent('isPredicted');
        $static->categoryIds = $data['categoryIds'] ?? new FilterCanBeAbsent('categoryIds');
        $static->brandIds = $data['brandIds'] ?? new FilterCanBeAbsent('brandIds');

        return $static;
    }

    public function toElasticFilter(): FullTextSearchFilterInterface
    {
        $productFilters = $this;

        return new class($productFilters) extends AbstractElasticSearchFilter
        {
            public function __construct(public readonly ProductFilters $productFilters)
            {
                $musts = [];

                if (! $productFilters->frontDisplay instanceof FilterCanBeAbsent) {
                    $musts[] = (new FrontDisplay($productFilters->frontDisplay))->toElasticQuery();
                }
                if (! $productFilters->onBiz instanceof FilterCanBeAbsent) {
                    $musts[] = (new OnBiz($productFilters->onBiz))->toElasticQuery();
                }
                if (! $productFilters->isPredicted instanceof FilterCanBeAbsent) {
                    $musts[] = (new IsPredicted([$productFilters->isPredicted]))->toElasticQuery();
                }
                if (! $productFilters->categoryIds instanceof FilterCanBeAbsent) {
                    $musts[] = (new CategoryIds($productFilters->categoryIds))->toElasticQuery();
                }
                if (! $productFilters->brandIds instanceof FilterCanBeAbsent) {
                    $musts[] = (new BrandIds($productFilters->brandIds))->toElasticQuery();
                }

                parent::__construct(must: $musts);
            }
        };
    }
}
