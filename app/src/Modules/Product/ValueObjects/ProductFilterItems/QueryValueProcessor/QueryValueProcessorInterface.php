<?php

namespace Modules\Product\ValueObjects\ProductFilterItems\QueryValueProcessor;

interface QueryValueProcessorInterface
{
    public function process(array &$queryValue): void;
}
