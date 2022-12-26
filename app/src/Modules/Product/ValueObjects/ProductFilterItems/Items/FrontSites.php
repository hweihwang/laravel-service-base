<?php

namespace Modules\Product\ValueObjects\ProductFilterItems\Items;

use JeroenG\Explorer\Domain\Syntax\Compound\BoolQuery;
use JeroenG\Explorer\Domain\Syntax\Matching;
use JeroenG\Explorer\Domain\Syntax\SyntaxInterface;
use Modules\Product\ValueObjects\ProductFilterItems\AbstractCmsFilterItem;
use Modules\Product\ValueObjects\ProductFilterItems\Concerns\TermsTrait;

final class FrontSites extends AbstractCmsFilterItem
{
    use TermsTrait;
    
    protected string $itemType = '';
    
    protected string $queryField = '';
    
    public function toElasticQuery(): SyntaxInterface
    {
        $boolQuery = new BoolQuery();
        
        $productBoolQuery = new BoolQuery();
        
        foreach ($this->queryValue as $value) {
            $productBoolQuery->add('should', new Matching('frontSites', $value, null));
        }
        
        $skuBoolQuery = new BoolQuery();
        
        foreach ($this->queryValue as $value) {
            $skuBoolQuery->add('should', new Matching('skus.frontSites', $value, null));
        }
        
        $boolQuery->add('must', $productBoolQuery);
        $boolQuery->add('must', $skuBoolQuery);
        
        return $boolQuery;
    }
}
