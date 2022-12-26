<?php

namespace Modules\Product\Commands;

use Modules\Common\Utils\RegexProvider;
use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\Enums\FrontDisplay;

final class CreateProductCommand extends AbstractValueObject
{
    public readonly string $name;

    public readonly ?string $shortDescription;

    public readonly FrontDisplay $frontDisplay;

    public readonly int $categoryId;

    public readonly int $brandId;

    public readonly bool $isPredicted;

    public readonly array $images;

    public readonly array $videos;

    public readonly ?string $youtubeVideo;

    public readonly array $tags;

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
        $static->isPredicted = $data['isPredicted'] ?? false;
        $static->images = $data['images'] ?? [];
        $static->videos = $data['videos'] ?? [];
        $static->youtubeVideo = $data['youtubeVideo'] ?? null;
        $static->frontDisplay = isset($data['frontDisplay']) ?
            FrontDisplay::fromName($data['frontDisplay']) : FrontDisplay::fromName('PUBLIC');
        $static->tags = $data['tags'] ?? [];

        return $static;
    }
}
