<?php

namespace Modules\Common\Hasher;

final class Sha256ObjectHasher implements ObjectHasherInterface
{
    public function hash(object $object): string
    {
        return hash('sha256', serialize($object));
    }
}
