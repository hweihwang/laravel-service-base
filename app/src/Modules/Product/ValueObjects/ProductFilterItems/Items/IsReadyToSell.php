<?php

namespace Modules\Product\ValueObjects\ProductFilterItems\Items;

use Illuminate\Support\Facades\Log;
use JeroenG\Explorer\Domain\Syntax\Compound\BoolQuery;
use JeroenG\Explorer\Domain\Syntax\Matching;
use JeroenG\Explorer\Domain\Syntax\Range;
use JeroenG\Explorer\Domain\Syntax\SyntaxInterface;
use JeroenG\Explorer\Domain\Syntax\Term;
use Modules\Product\ValueObjects\ProductFilterItems\AbstractCmsFilterItem;
use Modules\Product\ValueObjects\ProductFilterItems\Concerns\BoolTrait;

final class IsReadyToSell extends AbstractCmsFilterItem
{
    use BoolTrait;
    
    protected string $itemType = '';
    
    protected string $queryField = '';
    
    public function toElasticQuery(): SyntaxInterface
    {
        $boolQuery = new BoolQuery();
        
        foreach ($this->queryValue as $value) {
            if ($value) {
                $boolQuery->add('should', new Range('readyToSellQuantity', ['gt' => 0]));
            } else {
                $boolQuery->add('should', new Term('readyToSellQuantity', 0));
            }
        }

        return $boolQuery;
    }
}
