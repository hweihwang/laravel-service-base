<?php

namespace Modules\Product\Events;

use Ecotone\Modelling\Attribute\EventHandler;
use Ecotone\Modelling\EventBus;
use Modules\Product\ValueObjects\WillNotUpdate;

final class ProductWasUpdatedEventHandler
{
    #[EventHandler]
    public function __invoke(ProductWasUpdatedEvent $event, EventBus $eventBus): void
    {
        $product = $event->product;
        $command = $event->command;
        
        if (! $command->tags instanceof WillNotUpdate) {
            $eventBus->publish(new ProductTagsNeedToBeSyncedEvent($product, $command->tags));
        }
        if (! $command->frontSites instanceof WillNotUpdate) {
            $eventBus->publish(new ProductTenanciesNeedToBeSyncedEvent($product, $command->frontSites));
        }
    }
}
