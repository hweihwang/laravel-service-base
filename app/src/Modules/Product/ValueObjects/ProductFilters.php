<?php

namespace Modules\Product\ValueObjects;

use Illuminate\Support\Facades\Log;
use Modules\Common\Filters\AbstractElasticSearchFilter;
use Modules\Common\Filters\FullTextSearchFilterInterface;
use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\ValueObjects\ProductFilterItems\Items\BranchIds;
use Modules\Product\ValueObjects\ProductFilterItems\Items\BrandIds;
use Modules\Product\ValueObjects\ProductFilterItems\Items\CategoryIds;
use Modules\Product\ValueObjects\ProductFilterItems\Items\FrontDisplay;
use Modules\Product\ValueObjects\ProductFilterItems\Items\FrontSites;
use Modules\Product\ValueObjects\ProductFilterItems\Items\IsExhibited;
use Modules\Product\ValueObjects\ProductFilterItems\Items\IsIncoming;
use Modules\Product\ValueObjects\ProductFilterItems\Items\IsOnCustomerWaiting;
use Modules\Product\ValueObjects\ProductFilterItems\Items\IsOrdered;
use Modules\Product\ValueObjects\ProductFilterItems\Items\IsOutOfStock;
use Modules\Product\ValueObjects\ProductFilterItems\Items\IsPredicted;
use Modules\Product\ValueObjects\ProductFilterItems\Items\IsReadyToSell;
use Modules\Product\ValueObjects\ProductFilterItems\Items\OnBiz;
use Modules\Product\ValueObjects\ProductFilterItems\Items\SellPrice;

final class ProductFilters extends AbstractValueObject
{
    public readonly array|FilterCanBeAbsent $frontDisplay;

    public readonly array|FilterCanBeAbsent $onBiz;

    public readonly bool|FilterCanBeAbsent $isPredicted;

    public readonly array|FilterCanBeAbsent $frontSites;

    public readonly array|FilterCanBeAbsent $categoryIds;

    public readonly array|FilterCanBeAbsent $brandIds;

    public readonly array|FilterCanBeAbsent $branchIds;

    public readonly bool|FilterCanBeAbsent $isReadyToSell;

    public readonly bool|FilterCanBeAbsent $isIncoming;

    public readonly bool|FilterCanBeAbsent $isOnCustomerWaiting;

    public readonly bool|FilterCanBeAbsent $isOutOfStock;

    public readonly bool|FilterCanBeAbsent $isExhibited;

    public readonly bool|FilterCanBeAbsent $isOrdered;

    public readonly ProductPriceFilter|FilterCanBeAbsent $priceFilter;

    public static function fromArray(array $data): self
    {
        $static = new self();

        $static->frontDisplay = $data['frontDisplay'] ?? new FilterCanBeAbsent('frontDisplay');
        $static->onBiz = $data['onBiz'] ?? new FilterCanBeAbsent('onBiz');
        $static->isPredicted = $data['isPredicted'] ?? new FilterCanBeAbsent('isPredicted');
        $static->frontSites = $data['frontSites'] ?? new FilterCanBeAbsent('frontSites');
        $static->categoryIds = $data['categoryIds'] ?? new FilterCanBeAbsent('categoryIds');
        $static->brandIds = $data['brandIds'] ?? new FilterCanBeAbsent('brandIds');
        $static->branchIds = $data['branchIds'] ?? new FilterCanBeAbsent('branchIds');
        $static->isReadyToSell = $data['isReadyToSell'] ?? new FilterCanBeAbsent('isReadyToSell');
        $static->isIncoming = $data['isIncoming'] ?? new FilterCanBeAbsent('isIncoming');
        $static->isOnCustomerWaiting = $data['isOnCustomerWaiting'] ?? new FilterCanBeAbsent('isOnCustomerWaiting');
        $static->isOutOfStock = $data['isOutOfStock'] ?? new FilterCanBeAbsent('isOutOfStock');
        $static->isExhibited = $data['isExhibited'] ?? new FilterCanBeAbsent('isExhibited');
        $static->isOrdered = $data['isOrdered'] ?? new FilterCanBeAbsent('isOrdered');
        $static->priceFilter = isset($data['price']['min']) || isset($data['price']['max']) ? new ProductPriceFilter(
            $data['price']['min'] ?? null,
            $data['price']['max'] ?? null,
        ) : new FilterCanBeAbsent('priceFilter');

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
                if (! $productFilters->frontSites instanceof FilterCanBeAbsent) {
                    $musts[] = (new FrontSites($productFilters->frontSites))->toElasticQuery();
                }
                if (! $productFilters->categoryIds instanceof FilterCanBeAbsent) {
                    $musts[] = (new CategoryIds($productFilters->categoryIds))->toElasticQuery();
                }
                if (! $productFilters->brandIds instanceof FilterCanBeAbsent) {
                    $musts[] = (new BrandIds($productFilters->brandIds))->toElasticQuery();
                }
                if (! $productFilters->branchIds instanceof FilterCanBeAbsent) {
                    $musts[] = (new BranchIds($productFilters->branchIds))->toElasticQuery();
                }
                if (! $productFilters->isReadyToSell instanceof FilterCanBeAbsent) {
                    $musts[] = (new IsReadyToSell([$productFilters->isReadyToSell]))->toElasticQuery();
                }
                if (! $productFilters->isExhibited instanceof FilterCanBeAbsent) {
                    $musts[] = (new IsExhibited([$productFilters->isExhibited]))->toElasticQuery();
                }
                if (! $productFilters->isIncoming instanceof FilterCanBeAbsent) {
                    $musts[] = (new IsIncoming([$productFilters->isIncoming]))->toElasticQuery();
                }
                if (! $productFilters->isOrdered instanceof FilterCanBeAbsent) {
                    $musts[] = (new IsOrdered([$productFilters->isOrdered]))->toElasticQuery();
                }
                if (! $productFilters->isOutOfStock instanceof FilterCanBeAbsent) {
                    $musts[] = (new IsOutOfStock([$productFilters->isOutOfStock]))->toElasticQuery();
                }
                if (! $productFilters->isOnCustomerWaiting instanceof FilterCanBeAbsent) {
                    $musts[] = (new IsOnCustomerWaiting([$productFilters->isOnCustomerWaiting]))->toElasticQuery();
                }
                if (! $productFilters->priceFilter instanceof FilterCanBeAbsent) {
                    $musts[] = (new SellPrice([
                        [
                            'from' => $productFilters->priceFilter->min,
                            'to' => $productFilters->priceFilter->max,
                        ],
                    ]))->toElasticQuery();
                }

                parent::__construct(must: $musts);
            }
        };
    }
}
