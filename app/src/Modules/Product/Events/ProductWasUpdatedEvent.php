<?php

namespace Modules\Product\Events;

use Modules\Product\Commands\UpdateProductCommand;
use Modules\Product\Entities\Product;

final class ProductWasUpdatedEvent
{
    public function __construct(
        public Product $product,
        public UpdateProductCommand $command
    ) {
    }
}
