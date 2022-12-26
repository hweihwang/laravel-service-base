<?php

namespace Modules\Product\ValueObjects\ProductFilterItems\Concerns;

use Illuminate\Support\Str;
use JeroenG\Explorer\Domain\Syntax\Compound\BoolQuery;
use JeroenG\Explorer\Domain\Syntax\Matching;
use JeroenG\Explorer\Domain\Syntax\Range;
use JeroenG\Explorer\Domain\Syntax\SyntaxInterface;

trait TypedRangesTrait
{
    use RangesTrait;

    public function toElasticQuery(): SyntaxInterface
    {
        $boolQuery = new BoolQuery();

        $boolQuery->must(new Matching($this->typedField(), $this->typedFieldValue()));

        foreach ($this->queryValue as $value) {
            $boolQuery->should(new Range($this->queryField, $this->buildRanged($value)));
        }

        return $boolQuery;
    }

    public function typedField(): string
    {
        return 'attributes.code';
    }

    public function typedFieldValue(): string
    {
        return Str::snake(lcfirst(class_basename($this::class)));
    }
}
