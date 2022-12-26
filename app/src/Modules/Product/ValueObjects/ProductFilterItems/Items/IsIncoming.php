<?php

namespace Modules\Product\ValueObjects\ProductFilterItems\Items;

use JeroenG\Explorer\Domain\Syntax\Compound\BoolQuery;
use JeroenG\Explorer\Domain\Syntax\Matching;
use JeroenG\Explorer\Domain\Syntax\Range;
use JeroenG\Explorer\Domain\Syntax\SyntaxInterface;
use Modules\Product\ValueObjects\ProductFilterItems\AbstractCmsFilterItem;
use Modules\Product\ValueObjects\ProductFilterItems\Concerns\BoolTrait;

final class IsIncoming extends AbstractCmsFilterItem
{
    use BoolTrait;

    protected string $itemType = 'PRODUCT';

    protected string $queryField = 'skus.incomingQuantity';

    public function toElasticQuery(): SyntaxInterface
    {
        $boolQuery = new BoolQuery();

        foreach ($this->queryValue as $value) {
            if ($value) {
                $boolQuery->add('should', new Range($this->queryField, ['gt' => 0]));
            } else {
                $boolQuery->add('should', new Matching($this->queryField, 0, null));
            }
        }

        return $boolQuery;
    }
}
