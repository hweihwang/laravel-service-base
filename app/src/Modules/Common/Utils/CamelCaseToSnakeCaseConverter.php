<?php

namespace Modules\Common\Utils;

final class CamelCaseToSnakeCaseConverter
{
    public function __invoke(string $camelCase): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $camelCase));
    }
}
