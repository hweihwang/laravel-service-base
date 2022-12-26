<?php

namespace Modules\Product\ValueObjects\ProductFilterItems\Concerns;

use Modules\Product\ValueObjects\ProductFilterItems\QueryValueProcessor\BoolProcessor;

trait BoolTrait
{
    public function getProcessors(): array
    {
        return [
            new BoolProcessor(),
        ];
    }
}
