<?php

namespace Modules\Product\ValueObjects\ProductFilterItems\Concerns;

use JeroenG\Explorer\Domain\Syntax\Compound\BoolQuery;
use JeroenG\Explorer\Domain\Syntax\Range;
use JeroenG\Explorer\Domain\Syntax\SyntaxInterface;

trait RangesTrait
{
    protected function buildRanged(array $value): array
    {
        $ranged = [];

        if ($value['from']) {
            $ranged['gte'] = $value['from'];
        }

        if ($value['to']) {
            $ranged['lte'] = $value['to'];
        }

        return $ranged;
    }

    public function toElasticQuery(): SyntaxInterface
    {
        $boolQuery = new BoolQuery();

        foreach ($this->queryValue as $value) {
            $boolQuery->should(new Range($this->queryField, $this->buildRanged($value)));
        }

        return $boolQuery;
    }
}
