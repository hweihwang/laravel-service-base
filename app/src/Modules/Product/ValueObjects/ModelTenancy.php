<?php

namespace Modules\Product\ValueObjects;

use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\Enums\TenancyApp;

final class ModelTenancy extends AbstractValueObject
{
    public readonly string $modelType;

    public readonly int $modelId;

    public readonly TenancyApp $site;

    public static function fromArray(array $data): self
    {
        $static = new self();

        $static->modelType = $data['model_type'];
        $static->modelId = $data['model_id'];
        $static->site = TenancyApp::fromName($data['site']);

        return $static;
    }
}
