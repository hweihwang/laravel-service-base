<?php

namespace Modules\Product\ValueObjects\ProductFilterItems\Items;

use JeroenG\Explorer\Domain\Syntax\Compound\BoolQuery;
use JeroenG\Explorer\Domain\Syntax\Range;
use JeroenG\Explorer\Domain\Syntax\SyntaxInterface;
use JeroenG\Explorer\Domain\Syntax\Terms;
use Modules\Product\ValueObjects\ProductFilterItems\AbstractCmsFilterItem;

final class BranchIds extends AbstractCmsFilterItem
{
    protected string $itemType = 'SKU';
    
    protected string $queryField = 'skus.quantityByBranches';
    
    public function toElasticQuery(): SyntaxInterface
    {
        $boolQuery = new BoolQuery();
    
        $boolQuery->must(
            new Terms(
                $this->queryField . '.branchId',
                array_map(static fn($branchId) => (string)$branchId, $this->queryValue)
            )
        );
    
        $boolQuery->must(new Range($this->queryField . '.quantity', ['gte' => 1]));
    
        return $boolQuery;
    }
}
