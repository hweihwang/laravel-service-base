<?php

namespace Modules\Product\Transports\API\Controllers;

use Ecotone\Modelling\QueryBus;
use Illuminate\Http\JsonResponse;
use Modules\Common\Transports\API\APIController;
use Modules\Product\Queries\GetProductSkusQuery;

class ProductSkusController extends APIController
{
    public function __invoke(int $productId, QueryBus $queryBus): JsonResponse
    {
        $skus = $queryBus->send(new GetProductSkusQuery($productId));

        return $this->success([
            'data' => $skus,
        ]);
    }
}
