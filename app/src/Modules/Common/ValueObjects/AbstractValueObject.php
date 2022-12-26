<?php

declare(strict_types=1);

namespace Modules\Common\ValueObjects;

use Modules\Common\Models\StateGettableInterface;
use Modules\Common\Models\StateGettableTrait;

abstract class AbstractValueObject implements ValidatableInterface, ArrayableInterface, StateGettableInterface, ImmutableInterface
{
    use ValidatableTrait;
    use StateGettableTrait;
    use ArrayableTrait;
    use ImmutableTrait;
}
