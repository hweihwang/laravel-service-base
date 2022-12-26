<?php

namespace Modules\Product\Commands;

use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\EventBus;
use Illuminate\Support\Str;
use Modules\Common\Exceptions\CreateEntityException;
use Modules\Common\Hasher\Sha256ObjectHasher;
use Modules\Common\Interceptors\LockableCommandInterceptor;
use Modules\Common\Interceptors\TransactionableCommandInterceptor;
use Modules\Common\Locker\LockManager;
use Modules\Product\Entities\Product;
use Modules\Product\Events\ProductWasCreatedEvent;

final class CreateProductCommandHandler
{
    #[LockableCommandInterceptor(2, new LockManager(), new Sha256ObjectHasher())]
    #[TransactionableCommandInterceptor(new CreateEntityException('Product'))]
    #[CommandHandler]
    public function __invoke(CreateProductCommand $command, EventBus $eventBus): Product
    {
        $static = new Product();

        $static->name = $command->name;
        $static->brand_id = $command->brandId;
        $static->category_id = $command->categoryId;
        $static->short_description = $command->shortDescription;
        $static->images = $command->images;
        $static->videos = $command->videos;
        $static->youtube_video = $command->youtubeVideo;
        $static->front_display = $command->frontDisplay;
        $static->is_predicted = $command->isPredicted;
        $static->variant_settings = $command->variantSettings->serialize();
        $shared_url = Str::slug($static->name);
        $static->shared_url = $shared_url;

        $static->save();

        $eventBus->publish(new ProductWasCreatedEvent($static, $command));

        return $static;
    }
}
