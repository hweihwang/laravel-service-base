<?php

namespace Modules\Product\Queries;

use Carbon\Carbon;
use Ecotone\Modelling\Attribute\QueryHandler;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\Entities\SearchableProduct;
use Modules\Product\Repositories\ElasticsearchProductRepository;
use Modules\Product\Transports\API\ViewModels\ProductDetailSkuViewModel;
use Modules\Product\Transports\API\ViewModels\ProductListingViewModel;
use Modules\ProductOption\Repositories\SearchRepository\ElasticsearchProductOptionRepository;

final class GetProductsQueryHandler extends AbstractValueObject
{
    #[QueryHandler]
    public function __invoke(GetProductsQuery $query): LengthAwarePaginator
    {
        $model = new SearchableProduct();
        $repository = new ElasticsearchProductRepository($model);
        
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
        
        return $productViewModel;
    }
}
