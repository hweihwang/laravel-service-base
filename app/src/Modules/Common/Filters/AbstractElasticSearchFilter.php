<?php

declare(strict_types=1);

namespace Modules\Common\Filters;

use Modules\Common\ValueObjects\AbstractValueObject;

abstract class AbstractElasticSearchFilter extends AbstractValueObject implements FullTextSearchFilterInterface
{
    public function __construct(
        public readonly array $must = [],
        public readonly array $should = [],
        public readonly array $filter = [],
        public readonly array $rawFilterItems = [],
    ) {
    }

    public function getFilterItems(): array
    {
        return $this->rawFilterItems;
    }
}
