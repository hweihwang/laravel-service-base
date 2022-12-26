<?php

namespace Modules\Product\ValueObjects\ProductFilterItems\Concerns;

use JeroenG\Explorer\Domain\Syntax\Compound\BoolQuery;
use JeroenG\Explorer\Domain\Syntax\Matching;
use JeroenG\Explorer\Domain\Syntax\SyntaxInterface;

trait TermsTrait
{
    public function toElasticQuery(): SyntaxInterface
    {
        $boolQuery = new BoolQuery();

        foreach ($this->queryValue as $value) {
            $boolQuery->should(new Matching($this->queryField, $value, null));
        }

        return $boolQuery;
    }
}
