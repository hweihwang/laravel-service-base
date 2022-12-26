<?php

namespace Modules\Product\Queries;

use Applications\CMS\Sku\Entities\Sku;

final class NeedToGetSkuDetailQuery
{
    public function __construct(
        public Sku $sku,
    ) {
    }
}
