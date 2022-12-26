<?php

namespace Modules\Product\Transports\API\ViewModels;

use Modules\Common\Transports\API\ViewModel\AbstractViewModel;

final class ProductListingViewModel extends AbstractViewModel
{
    public int $productId;

    public string $name;

    public string $frontDisplay;

    public int $readyToSellQuantity;

    public int $incomingQuantity;

    public ?int $lastSoldAt;

    public int $soldInLast7DaysQuantity;

    /**
     * @var array<ProductDetailSkuViewModel>
     */
    public array $skus;

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
