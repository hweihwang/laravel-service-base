<?php

declare(strict_types=1);

namespace Modules\Common\Transports\API\ViewModel;

interface ViewModelInterface
{
    public function toArray(): array;
}
