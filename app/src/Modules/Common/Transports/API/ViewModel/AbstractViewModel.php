<?php

declare(strict_types=1);

namespace Modules\Common\Transports\API\ViewModel;

use Illuminate\Support\Str;

abstract class AbstractViewModel implements ViewModelInterface
{
    public function toArray(): array
    {
        $resultArray = [];

        foreach ($this as $key => $value) {
            $resultArray[Str::snake($key)] = $value;
        }

        return $resultArray;
    }
}
