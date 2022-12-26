<?php

namespace Modules\Product\Events;

use Ecotone\Modelling\Attribute\EventHandler;

final class ProductTagsNeedToBeSyncedEventHandler
{
    #[EventHandler]
    public function __invoke(ProductTagsNeedToBeSyncedEvent $event): void
    {
        $event->product->tags()->sync($event->tags);
    }
}
