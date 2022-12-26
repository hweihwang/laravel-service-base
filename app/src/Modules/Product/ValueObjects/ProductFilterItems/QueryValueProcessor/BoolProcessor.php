<?php

namespace Modules\Product\ValueObjects\ProductFilterItems\QueryValueProcessor;

final class BoolProcessor implements QueryValueProcessorInterface
{
    public function process(array &$queryValue): void
    {
        foreach ($queryValue as &$value) {
            $value = (bool)$value;
        }
    }
}
