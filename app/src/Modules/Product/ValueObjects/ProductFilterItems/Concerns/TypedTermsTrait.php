<?php

namespace Modules\Product\ValueObjects\ProductFilterItems\Concerns;

use Illuminate\Support\Str;
use JeroenG\Explorer\Domain\Syntax\Compound\BoolQuery;
use JeroenG\Explorer\Domain\Syntax\Matching;
use JeroenG\Explorer\Domain\Syntax\SyntaxInterface;
use JeroenG\Explorer\Domain\Syntax\Terms;

trait TypedTermsTrait
{
    public function toElasticQuery(): SyntaxInterface
    {
        $boolQuery = new BoolQuery();
    
        $boolQuery->must(new Matching($this->typedField(), $this->typedFieldValue()));
    
        $boolQuery->must(new Terms($this->queryField, $this->queryValue));
    
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
