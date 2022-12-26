<?php

namespace Modules\Common\Hasher;

interface ObjectHasherInterface
{
    public function hash(object $object): string;
}
