<?php

namespace Modules\Product\Transports\API\ViewModels;

use Modules\Common\Transports\API\ViewModel\AbstractViewModel;

final class ProductDetailSkuViewModel extends AbstractViewModel
{
    public int $skuId;

    public string $SKU;

    public ?string $MPN;

    public bool $onBiz;

    public int $price;

    public int $sellPrice;

    public ?string $specs;

    public string $colorName;

    public int $readyToSellQuantity;

    public int $incomingQuantity;

    public int $orderedQuantity;

    public int $customerWaitingQuantity;

    public int $exhibitionQuantity;

    public int $errorQuantity;

    public ?int $lastSoldAt;

    public int $soldInLast7DaysQuantity;

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
