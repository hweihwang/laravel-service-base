<?php

namespace Modules\Product\Enums;

use Modules\Common\Utils\CamelCaseToSnakeCaseConverter;

trait HasPropertyTrait
{
    public function property(): string
    {
        return (new CamelCaseToSnakeCaseConverter())($this->value);
    }
}
