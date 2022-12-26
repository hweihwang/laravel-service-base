<?php

declare(strict_types=1);

namespace Modules\Common\ValueObjects;

use Illuminate\Support\Facades\Validator;
use RuntimeException;

trait ValidatableTrait
{
    public function isValid(array $data = [], array $rules = []): bool
    {
        if ([] === $rules) {
            if (method_exists($this, 'rules')) {
                $rules = $this->rules();
            } else {
                throw new RuntimeException('No rules defined for '.static::class);
            }
        }

        if ([] === $data) {
            if (method_exists($this, 'toArray')) {
                $data = $this->toArray();
            } else {
                throw new RuntimeException('No data defined for '.static::class);
            }
        }

        return Validator::make($data, $rules)->passes();
    }
}
