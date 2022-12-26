<?php

namespace Modules\Product\ValueObjects;

use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\Enums\SkuWillHavePropertyOf;

final class SkuWillHaveProperty extends AbstractValueObject
{
    public readonly SkuWillHavePropertyOf $skuWillHavePropertyOf;

    public readonly mixed $skuWillHavePropertyWithValue;

    public readonly ?int $specId;

    public static function fromArray(array $data): self
    {
        $static = new self();

        $static->skuWillHavePropertyOf = SkuWillHavePropertyOf::fromName($data['skuWillHavePropertyOf']);
        $static->skuWillHavePropertyWithValue = $data['skuWillHavePropertyWithValue'];
        $static->specId = $data['specId'] ?? null;

        return $static;
    }

    public function serialize(): array
    {
        return [
            'skuWillHavePropertyOf' => $this->skuWillHavePropertyOf->name,
            'skuWillHavePropertyWithValue' => $this->skuWillHavePropertyWithValue,
            'specId' => $this->specId,
        ];
    }
}
