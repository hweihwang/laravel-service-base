<?php

namespace Modules\Product\Enums;

enum FrontDisplay: int
{
    use CanCreateFromNameTrait;
    case PUBLIC = 1;
    case SEO_ONLY = 2;
    case HIDDEN = 0;
}
