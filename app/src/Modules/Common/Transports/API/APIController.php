<?php

declare(strict_types=1);

namespace Modules\Common\Transports\API;

use Illuminate\Routing\Controller;
use Modules\Common\Transports\API\Concerns\APIFoundationTrait;

class APIController extends Controller
{
    use APIFoundationTrait;
}
