<?php

namespace Modules\Product\Commands;

use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\EventBus;
use Modules\Common\Exceptions\UpdateEntityException;
use Modules\Common\Hasher\Sha256ObjectHasher;
use Modules\Common\Interceptors\LockableCommandInterceptor;
use Modules\Common\Interceptors\TransactionableCommandInterceptor;
use Modules\Common\Locker\LockManager;
use Modules\Product\Entities\Product;
use Modules\Product\Events\ProductWasUpdatedEvent;
use Modules\Product\ValueObjects\WillNotUpdate;

final class UpdateProductCommandHandler
{
    #[LockableCommandInterceptor(2, new LockManager(), new Sha256ObjectHasher())]
    #[TransactionableCommandInterceptor(new UpdateEntityException('Product'))]
    #[CommandHandler]
    public function __invoke(UpdateProductCommand $command, EventBus $eventBus): Product
    {
        /** @var Product $static */
        $static = Product::query()->find($command->productId);

        if (! $command->name instanceof WillNotUpdate) {
            $static->name = $command->name;
        }
        if (! $command->brandId instanceof WillNotUpdate) {
            $static->brand_id = $command->brandId;
        }
        if (! $command->categoryId instanceof WillNotUpdate) {
            $static->category_id = $command->categoryId;
        }
        if (! $command->shortDescription instanceof WillNotUpdate) {
            $static->short_description = $command->shortDescription;
        }
        if (! $command->images instanceof WillNotUpdate) {
            $static->images = $command->images;
        }
        if (! $command->images instanceof WillNotUpdate) {
            $static->images = $command->images;
        }
        if (! $command->videos instanceof WillNotUpdate) {
            $static->videos = $command->videos;
        }
        if (! $command->youtubeVideo instanceof WillNotUpdate) {
            $static->youtube_video = $command->youtubeVideo;
        }
        if (! $command->frontDisplay instanceof WillNotUpdate) {
            $static->front_display = $command->frontDisplay;
        }
        if (! $command->isPredicted instanceof WillNotUpdate) {
            $static->is_predicted = $command->isPredicted;
        }
        if (! $command->variantSettings instanceof WillNotUpdate) {
            $static->variant_settings = $command->variantSettings->serialize();
        }

        $static->save();

        $eventBus->publish(new ProductWasUpdatedEvent($static, $command));

        return $static;
    }
}
