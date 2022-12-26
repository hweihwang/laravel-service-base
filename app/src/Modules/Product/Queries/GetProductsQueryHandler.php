<?php

namespace Modules\Product\Queries;

use Carbon\Carbon;
use Ecotone\Modelling\Attribute\QueryHandler;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\Entities\SearchableProduct;
use Modules\Product\Transports\API\ViewModels\ProductDetailSkuViewModel;
use Modules\Product\Transports\API\ViewModels\ProductListingViewModel;
use Modules\ProductOption\Repositories\SearchRepository\ElasticsearchProductOptionRepository;

final class GetProductsQueryHandler extends AbstractValueObject
{
    #[QueryHandler]
    public function __invoke(GetProductsQuery $query): LengthAwarePaginator
    {
        $model = new SearchableProduct();
        $repository = new ElasticsearchProductOptionRepository($model);
        
        $filters = $query->filters->toElasticFilter();
        $search = $query->search;
        $sorts = $query->sorts;
        $paging = $query->paging;
        
        $products = $repository->filterPaginated(
            filters: $filters,
            perPage: $paging->perPage,
            page: $paging->currentPage,
            orderBy: $sorts->sortBy->property(),
            direction: $sorts->direction->property(),
            search: $search,
        );
        
        $products->getCollection()->transform(
            fn(array $product) => $this->transformToProductViewModel($product)->toArray()
        );
        
        return $products;
    }
    
    private function transformToProductViewModel(array $product): ProductListingViewModel
    {
        $productViewModel = new ProductListingViewModel();
        $productViewModel->productId = $product['productId'];
        $productViewModel->name = $product['name'];
        $productViewModel->frontDisplay = $product['frontDisplay'];
        $productViewModel->readyToSellQuantity = $product['readyToSellQuantity'];
        $productViewModel->incomingQuantity = $product['incomingQuantity'];
        $productViewModel->lastSoldAt = $product['lastSoldAt'] ? Carbon::parse(
            $product['lastSoldAt']
        )->diffInDays() : null;
        $productViewModel->soldInLast7DaysQuantity = $product['soldInLast7DaysQuantity'];
        $productViewModel->skus = array_map(fn(array $sku) => $this->transformToSkuViewModel($sku)->toArray(),
            $product['skus']);
        
        return $productViewModel;
    }
    
    private function transformToSkuViewModel(array $sku): ProductDetailSkuViewModel
    {
        $skuViewModel = new ProductDetailSkuViewModel();
        
        $skuViewModel->skuId = $sku['skuId'];
        $skuViewModel->SKU = $sku['SKU'];
        $skuViewModel->MPN = $sku['MPN'];
        $skuViewModel->onBiz = $sku['onBiz'];
        $skuViewModel->price = $sku['price'];
        $skuViewModel->sellPrice = $sku['sellPrice'];
        $skuViewModel->specs = $sku['specs'];
        $skuViewModel->colorName = $sku['colorName'];
        $skuViewModel->readyToSellQuantity = $sku['readyToSellQuantity'];
        $skuViewModel->incomingQuantity = $sku['incomingQuantity'];
        $skuViewModel->orderedQuantity = $sku['orderedQuantity'];
        $skuViewModel->customerWaitingQuantity = $sku['customerWaitingQuantity'];
        $skuViewModel->exhibitionQuantity = $sku['exhibitionQuantity'];
        $skuViewModel->errorQuantity = $sku['errorQuantity'];
        $skuViewModel->lastSoldAt = $sku['lastSoldAt'] ? Carbon::parse($sku['lastSoldAt'])->diffInDays() : null;
        $skuViewModel->soldInLast7DaysQuantity = $sku['soldInLast7DaysQuantity'];
        
        return $skuViewModel;
    }
}
