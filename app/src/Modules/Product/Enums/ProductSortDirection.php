<?php

namespace Modules\Product\Enums;

enum ProductSortDirection: string
{
    use CanCreateFromNameTrait;
    use HasPropertyTrait;
    
    case ASC = 'ASC';
    case DESC = 'DESC';
    
    public function property(): string
    {
        return match ($this) {
            self::ASC => 'asc',
            self::DESC => 'desc',
        };
    }
}
