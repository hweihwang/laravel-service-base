<?php

namespace Modules\Product\Transports\API\ViewModels;

use Applications\CMS\Sku\Transports\API\ViewModels\SkuDetailViewModel;
use Modules\Common\Transports\API\ViewModel\AbstractViewModel;

final class ProductSkusViewModel extends AbstractViewModel
{
    /** @var array<SkuDetailViewModel> */
    public array $skus;

    public function toArray(): array
    {
        return $this->skus;
    }
}
