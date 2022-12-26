<?php

namespace Modules\Product\ValueObjects;

use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\Enums\SkuWhichHadPropertyOf;

final class SkuWhichHadProperty extends AbstractValueObject
{
    public readonly SkuWhichHadPropertyOf $skuWhichHadPropertyOf;

    public readonly mixed $skuWhichHadPropertyWithValue;

    //public readonly ?int $specId;

    public static function fromArray(array $data): self
    {
        $static = new self();

        $static->skuWhichHadPropertyOf = SkuWhichHadPropertyOf::fromName($data['skuWhichHadPropertyOf']);
        $static->skuWhichHadPropertyWithValue = $data['skuWhichHadPropertyWithValue'] ?? null;
        //$static->specId = $data['specId'] ?? null;

        return $static;
    }

    public function withValue(mixed $value): self
    {
        $serialized = $this->serialize();

        $serialized['skuWhichHadPropertyWithValue'] = $value;

        return self::fromArray($serialized);
    }

    public function serialize(): array
    {
        return [
            'skuWhichHadPropertyOf' => $this->skuWhichHadPropertyOf->name,
            'skuWhichHadPropertyWithValue' => $this->skuWhichHadPropertyWithValue,
        ];
    }
}
