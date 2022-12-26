<?php

namespace Modules\Product\ValueObjects;

use Modules\Common\ValueObjects\AbstractValueObject;

final class VariantSettings extends AbstractValueObject
{
    /** @var array<VariantSetting> */
    public readonly array $settings;

    public static function fromArray(array $data): self
    {
        $static = new self();
        $settings = [];

        foreach ($data as $variantSetting) {
            $settings[] = VariantSetting::fromArray($variantSetting);
        }

        $static->settings = $settings;

        return $static;
    }

    public function toArray(): array
    {
        return $this->settings;
    }

    public function serialize(): array
    {
        return array_map(static fn (VariantSetting $setting) => $setting->serialize(), $this->settings);
    }
}
