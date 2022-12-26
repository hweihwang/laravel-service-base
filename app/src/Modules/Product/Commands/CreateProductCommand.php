<?php

namespace Modules\Product\Commands;

use Modules\Common\Utils\RegexProvider;
use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\Enums\FrontDisplay;
use Modules\Product\Enums\TenancyApp;
use Modules\Product\ValueObjects\VariantSettings;
use Webmozart\Assert\Assert;

final class CreateProductCommand extends AbstractValueObject
{
    public readonly string $name;

    public readonly ?string $shortDescription;

    public readonly FrontDisplay $frontDisplay;

    public readonly int $categoryId;

    public readonly int $brandId;

    public readonly VariantSettings $variantSettings;

    public readonly bool $isPredicted;

    public readonly array $images;

    public readonly array $videos;

    public readonly ?string $youtubeVideo;

    public readonly array $tags;

    /** @var array<TenancyApp> */
    public readonly array $frontSites;

    public static function fromArray(array $data): self
    {
        //Validate here
        Assert::stringNotEmpty($data['name']);
        Assert::positiveInteger($data['categoryId']);
        Assert::positiveInteger($data['brandId']);
        if (isset($data['youtubeVideo'])) {
            Assert::regex($data['youtubeVideo'], (new RegexProvider())->youtubeVideo(), 'Invalid youtube video url');
        }
        //Mapping logic
        $static = new self();

        $static->name = $data['name'];
        $static->shortDescription = $data['shortDescription'] ?? null;
        $static->categoryId = $data['categoryId'];
        $static->brandId = $data['brandId'];
        $static->variantSettings = isset($data['variantSettings']) ?
            VariantSettings::fromArray($data['variantSettings']) : VariantSettings::fromArray([]);
        $static->isPredicted = $data['isPredicted'] ?? false;
        $static->images = $data['images'] ?? [];
        $static->videos = $data['videos'] ?? [];
        $static->youtubeVideo = $data['youtubeVideo'] ?? null;

        $static->frontDisplay = isset($data['frontDisplay']) ?
            FrontDisplay::fromName($data['frontDisplay']) : FrontDisplay::fromName('PUBLIC');
        $static->tags = $data['tags'] ?? [];
        $static->frontSites = isset($data['frontSites']) ? array_map(static fn ($site) => TenancyApp::from($site),
            $data['frontSites']) : [];

        return $static;
    }
}
