<?php

namespace Modules\Product\Events;

use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\Entities\Product;

final class ProductTagsNeedToBeSyncedEvent extends AbstractValueObject
{
    public function __construct(public readonly Product $product, public readonly array $tags)
    {
    }
}
