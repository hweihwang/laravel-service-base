<?php

declare(strict_types=1);

namespace Modules\Common\ValueObjects;

trait ArrayableTrait
{
//    public static function fromArray(array $data): self
//    {
//        try {
//            $static = new static();
//
//            $validator = $static->getValidator($data);
//
//            if ($validator->fails()) {
//                throw app('exception.default', ['message' => 'Validation failed on '.$static::class]);
//            }
//            //Do mapping data to object properties here
//            $static = app('auto_mapper.mapper')->mapToObject($data, $static);
//
//            /** @var ImmutableInterface $static */
//            $static->initialState = $static->toArray();
//
//            return $static;
//        } catch (\Throwable $e) {
//            throw new \RuntimeException($e->getMessage());
//        }
//    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
