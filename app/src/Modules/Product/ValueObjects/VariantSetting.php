<?php

namespace Modules\Product\ValueObjects;

use Modules\Common\ValueObjects\AbstractValueObject;

final class VariantSetting extends AbstractValueObject
{
    public readonly SkuWhichHadProperty $skuWhichHadProperty;

    public readonly SkuWillHaveProperty $skuWillHaveProperty;

    public static function fromArray(array $data): self
    {
        $static = new self();

        $static->skuWhichHadProperty = SkuWhichHadProperty::fromArray($data['skuWhichHadProperty']);
        $static->skuWillHaveProperty = SkuWillHaveProperty::fromArray($data['skuWillHaveProperty']);

        return $static;
    }

    public function serialize(): array
    {
        return [
            'skuWhichHadProperty' => $this->skuWhichHadProperty->serialize(),
            'skuWillHaveProperty' => $this->skuWillHaveProperty->serialize(),
        ];
    }
}
