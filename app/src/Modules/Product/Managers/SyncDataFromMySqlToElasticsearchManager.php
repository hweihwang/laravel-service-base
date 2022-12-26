<?php

namespace Modules\Product\Managers;

use Modules\Product\Entities\Product;
use Modules\Product\Entities\SearchableProduct;
use Modules\Product\Repositories\ElasticsearchProductRepository;

final  class SyncDataFromMySqlToElasticsearchManager
{
    public function __construct(public ElasticsearchProductRepository $repository)
    {
    }
    
    public function __invoke(): void
    {
        [$toInsert, $toDelete] = $this->computeDiffs();
        
        $this->insert($toInsert);
        $this->delete($toDelete);
    }
    
    private function getElasticsearchIds(): array
    {
        return $this->repository->filterPaginated(perPage: 10000, orderBy: null)->getCollection()->pluck(
            'productId'
        )->values()->all();
    }
    
    private function getMySqlIds(): array
    {
        return Product::query()->pluck('id')->all();
    }
    
    private function computeDiffs(): array
    {
        $elasticSearchIds = $this->getElasticsearchIds();
        $mySqlIds = $this->getMySqlIds();
        
        $toUpdate = Product::query()
            ->whereIn('id', $elasticSearchIds)
            ->whereIn('id', $mySqlIds)
            ->where('updated_at', '>', now()->subMinutes(3))
            ->pluck('id')
            ->all();
        
        $toInsert = array_diff($mySqlIds, $elasticSearchIds);
        
        $toInsert = array_unique(array_merge($toInsert, $toUpdate));
        
        $toDelete = array_diff($elasticSearchIds, $mySqlIds);
        
        return [$toInsert, $toDelete];
    }
    
    private function insert(array $toInsert): void
    {
        $willInsert = [];
        
        Product::query()
            ->whereIn('id', $toInsert)
            ->orderBy('id', 'desc')
            ->lazy(10000)
            ->each(function (Product $product) use (&$willInsert) {
                $willInsert[] = $this->convertProductFromMySqlToElasticsearch($product);
            });
        
        $this->repository->bulkAdd(collect($willInsert));
    }
    
    private function convertProductFromMySqlToElasticsearch(Product $product): SearchableProduct
    {
        return SearchableProduct::fromArray([
            'productId' => $product->id,
            'name' => $product->name,
            'categoryId' => $product->category_id,
            'brandId' => $product->brand_id,
            'isPredicted' => $product->is_predicted,
            'frontDisplay' => $product->front_display->name,
        ]);
    }
    
    private function delete(array $toDelete): void
    {
        $service = new ProductOptionDeleteService($this->repository);
        
        $dto = new ProductOptionDataDeleteDTO($toDelete);
        
        $service->execute($dto);
    }
}
