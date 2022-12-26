<?php

namespace Modules\Product\ValueObjects;

use Applications\CMS\Sku\Enums\Condition;
use Applications\CMS\Sku\Enums\Source;
use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\Enums\FrontDisplay;
use Modules\Product\Enums\TenancyApp;

final class Sku extends AbstractValueObject
{
    public readonly int $skuId;

    public readonly int $productId;

    public readonly string $SKU;

    public readonly ?string $MPN;

    public readonly ?string $modelName;

    public readonly bool $onBiz;

    public readonly Condition $condition;

    public readonly Source $source;

    public readonly int $price;

    public readonly int $sellPrice;

    public readonly ?string $specs;

    public readonly FrontDisplay $frontDisplay;

    /**
     * @var array<TenancyApp>
     */
    public readonly array $frontSites;

    public readonly string $colorName;

    public readonly int $colorId;

    public readonly int $colorGroupId;

    /**
     * @var array<QuantityByBranch>
     */
    public readonly array $quantityByBranches;

    public readonly int $canSellQuantity;

    public readonly int $readyToSellQuantity;

    public readonly int $incomingQuantity;

    public readonly int $orderedQuantity;

    public readonly int $customerWaitingQuantity;

    public readonly int $exhibitionQuantity;

    public readonly int $errorQuantity;

    public readonly int $lastSoldAt;

    public readonly int $soldInLast7DaysQuantity;

    public static function fromArray(array $data): self
    {
        $static = new self();

        $static->skuId = $data['skuId'];
        $static->productId = $data['productId'];
        $static->SKU = $data['SKU'];
        $static->MPN = $data['MPN'] ?? null;
        $static->modelName = $data['modelName'] ?? null;
        $static->onBiz = $data['onBiz'];
        $static->condition = Condition::fromName($data['condition']);
        $static->source = Source::fromName($data['source']);
        $static->price = $data['price'];
        $static->sellPrice = $data['sellPrice'];
        $static->specs = $data['specs'];
        $static->frontDisplay = FrontDisplay::fromName($data['frontDisplay']);
        $static->frontSites = array_map(static fn (string $site) => TenancyApp::fromName($site), $data['frontSites']);
        $static->colorName = $data['colorName'];
        $static->colorId = $data['colorId'];
        $static->colorGroupId = $data['colorGroupId'];
        $static->quantityByBranches = array_map(
            static fn (array $quantityByBranch) => new QuantityByBranch(
                $quantityByBranch['branchId'],
                $quantityByBranch['quantity']
            ),
            $data['quantityByBranches']
        );
        $static->canSellQuantity = $data['canSellQuantity'];
        $static->readyToSellQuantity = $data['readyToSellQuantity'];
        $static->incomingQuantity = $data['incomingQuantity'];
        $static->orderedQuantity = $data['orderedQuantity'];
        $static->customerWaitingQuantity = $data['customerWaitingQuantity'];
        $static->exhibitionQuantity = $data['exhibitionQuantity'];
        $static->errorQuantity = $data['errorQuantity'];
        $static->lastSoldAt = $data['lastSoldAt'];
        $static->soldInLast7DaysQuantity = $data['soldInLast7DaysQuantity'];

        return $static;
    }

    public function toArray(): array
    {
        return [
            'skuId' => $this->skuId,
            'productId' => $this->productId,
            'SKU' => $this->SKU,
            'MPN' => $this->MPN,
            'modelName' => $this->modelName,
            'onBiz' => $this->onBiz,
            'condition' => $this->condition->name,
            'source' => $this->source->name,
            'price' => $this->price,
            'sellPrice' => $this->sellPrice,
            'specs' => $this->specs,
            'frontDisplay' => $this->frontDisplay->name,
            'frontSites' => array_map(static fn (TenancyApp $site) => $site->name, $this->frontSites),
            'colorName' => $this->colorName,
            'colorId' => $this->colorId,
            'colorGroupId' => $this->colorGroupId,
            'quantityByBranches' => array_map(
                static fn (QuantityByBranch $quantityByBranch) => $quantityByBranch->toArray(),
                $this->quantityByBranches
            ),
            'canSellQuantity' => $this->canSellQuantity,
            'readyToSellQuantity' => $this->readyToSellQuantity,
            'incomingQuantity' => $this->incomingQuantity,
            'orderedQuantity' => $this->orderedQuantity,
            'customerWaitingQuantity' => $this->customerWaitingQuantity,
            'exhibitionQuantity' => $this->exhibitionQuantity,
            'errorQuantity' => $this->errorQuantity,
            'lastSoldAt' => $this->lastSoldAt,
            'soldInLast7DaysQuantity' => $this->soldInLast7DaysQuantity,
        ];
    }
}
