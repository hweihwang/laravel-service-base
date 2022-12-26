<?php

namespace Modules\Product\ValueObjects\ProductFilterItems;

use JeroenG\Explorer\Domain\Syntax\SyntaxInterface;

interface ElasticFilterItemInterface
{
    public function getQueryField(): string;

    public function getItemType(): string;

    public function getProcessors(): array;

    public function getQueryValue(): array;

    public function toElasticQuery(): SyntaxInterface;
}
