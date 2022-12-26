<?php

namespace Modules\Product\Events;

use Ecotone\Modelling\Attribute\EventHandler;
use Ecotone\Modelling\EventBus;

final class ProductWasCreatedEventHandler
{
    #[EventHandler]
    public function __invoke(ProductWasCreatedEvent $event, EventBus $eventBus): void
    {
        $product = $event->product;
        
        $eventBus->publish(new ProductTagsNeedToBeSyncedEvent($product, $event->command->tags));
        $eventBus->publish(new ProductTenanciesNeedToBeSyncedEvent($product, $event->command->frontSites));
    }
}
