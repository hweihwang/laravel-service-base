<?php

namespace Modules\Product\Transports\API\ViewModels;

use Modules\Common\Transports\API\ViewModel\AbstractViewModel;
final class ProductDetailViewModel extends AbstractViewModel
{
    public int $productId;

    public string $name;

    public ?string $shortDescription;

    public string $frontDisplay;

    public int $categoryId;

    public int $brandId;

    public array $variantSettings;

    public bool $isPredicted;

    public ?array $images;

    public ?array $videos;

    public ?string $youtubeVideo;

    public array $tags;

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
