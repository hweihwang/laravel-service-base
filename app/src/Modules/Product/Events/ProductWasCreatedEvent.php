<?php

namespace Modules\Product\Events;

use Modules\Product\Commands\CreateProductCommand;
use Modules\Product\Entities\Product;

final readonly class ProductWasCreatedEvent
{
    public function __construct(
        public Product $product,
        public CreateProductCommand $command
    ) {
    }
}
