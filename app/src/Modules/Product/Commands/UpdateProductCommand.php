<?php

namespace Modules\Product\Commands;

use Modules\Common\Utils\RegexProvider;
use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\Enums\FrontDisplay;
use Modules\Product\Enums\TenancyApp;
use Modules\Product\ValueObjects\VariantSettings;
use Modules\Product\ValueObjects\WillNotUpdate;
use Webmozart\Assert\Assert;

final class UpdateProductCommand extends AbstractValueObject
{
    public readonly int $productId;

    public readonly string|WillNotUpdate $name;

    public readonly string|null|WillNotUpdate $shortDescription;

    public readonly FrontDisplay|WillNotUpdate $frontDisplay;

    public readonly int|WillNotUpdate $categoryId;

    public readonly int|WillNotUpdate $brandId;

    public readonly VariantSettings|WillNotUpdate $variantSettings;

    public readonly bool|WillNotUpdate $isPredicted;

    public readonly array|WillNotUpdate $images;

    public readonly array|WillNotUpdate $videos;

    public readonly string|null|WillNotUpdate $youtubeVideo;

    public readonly array|WillNotUpdate $tags;

    /** @var array<TenancyApp> */
    public readonly array|WillNotUpdate $frontSites;

    public static function fromArray(array $data): self
    {
        //Validate here
        Assert::positiveInteger($data['productId']);
        if (isset($data['youtubeVideo'])) {
            Assert::regex($data['youtubeVideo'], (new RegexProvider())->youtubeVideo(), 'Invalid youtube video url');
        }
        //Mapping logic
        $static = new self();

        $static->productId = $data['productId'];

        $static->name = $data['name'] ?? new WillNotUpdate();
        $static->shortDescription = $data['shortDescription'] ?? new WillNotUpdate();
        $static->categoryId = $data['categoryId'] ?? new WillNotUpdate();
        $static->brandId = $data['brandId'] ?? new WillNotUpdate();
        $static->variantSettings = isset($data['variantSettings']) ?
            VariantSettings::fromArray($data['variantSettings']) : new WillNotUpdate();
        $static->isPredicted = $data['isPredicted'] ?? new WillNotUpdate();
        $static->images = $data['images'] ?? new WillNotUpdate();
        $static->videos = $data['videos'] ?? new WillNotUpdate();
        $static->youtubeVideo = $data['youtubeVideo'] ?? new WillNotUpdate();

        $static->frontDisplay = isset($data['frontDisplay']) ?
            FrontDisplay::fromName($data['frontDisplay']) : new WillNotUpdate();
        $static->tags = $data['tags'] ?? new WillNotUpdate();
        $static->frontSites = isset($data['frontSites']) ? array_map(static fn ($site) => TenancyApp::from($site),
            $data['frontSites']) : new WillNotUpdate();

        return $static;
    }
}
