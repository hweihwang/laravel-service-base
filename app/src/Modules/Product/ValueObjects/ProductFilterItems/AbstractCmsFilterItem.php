<?php

namespace Modules\Product\ValueObjects\ProductFilterItems;

use Applications\Nicespace\Common\DTOs\FilterItems\QueryValueProcessor\QueryValueProcessorInterface;
use RuntimeException;

abstract class AbstractCmsFilterItem implements ElasticFilterItemInterface
{
    protected array $queryValue;

    protected string $itemType;

    protected string $queryField;

    public function getQueryValue(): array
    {
        return $this->queryValue;
    }

    public function getItemType(): string
    {
        return $this->itemType;
    }

    public function getQueryField(): string
    {
        return $this->queryField;
    }

    /**
     * @return array<QueryValueProcessorInterface>
     */
    public function getProcessors(): array
    {
        return [];
    }

    public function __construct(array $queryValue)
    {
        if ([] === $queryValue) {
            throw new RuntimeException('Query value cannot be empty');
        }

        foreach ($this->getProcessors() as $processor) {
            $processor->process($queryValue);
        }

        $this->queryValue = $queryValue;
    }
}
