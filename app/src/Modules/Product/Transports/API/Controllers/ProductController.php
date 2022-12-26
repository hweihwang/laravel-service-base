<?php

namespace Modules\Product\Transports\API\Controllers;

use Ecotone\Modelling\CommandBus;
use Ecotone\Modelling\QueryBus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Common\Transports\API\APIController;
use Modules\Product\Commands\CreateProductCommand;
use Modules\Product\Commands\UpdateProductCommand;
use Modules\Product\Entities\Product;
use Modules\Product\Queries\GetProductDetailQuery;
use Modules\Product\Queries\GetProductsQuery;
use Modules\Product\Transports\API\Paging\ListProductsPaging;

class ProductController extends APIController
{
    public function create(Request $request, CommandBus $commandBus, QueryBus $queryBus): JsonResponse
    {
        /** @var Product $createdProduct */
        $createdProduct = $commandBus->send(CreateProductCommand::fromArray($request->all()));
        
        return $this->success([
            'data' => $queryBus->send(new GetProductDetailQuery($createdProduct->id)),
        ]);
    }
    
    public function list(Request $request, QueryBus $queryBus): JsonResponse
    {
        /** @var LengthAwarePaginator $pagingProducts */
        $pagingProducts = $queryBus->send(GetProductsQuery::fromArray($request->all()));
        
        return $this->success(
            data: $pagingProducts,
            paging: new ListProductsPaging(),
        );
    }
    
    public function update(int $productId, Request $request, CommandBus $commandBus, QueryBus $queryBus): JsonResponse
    {
        $commandBus->send(
            UpdateProductCommand::fromArray(
                array_merge(['productId' => $productId], $request->all())
            )
        );
        
        return $this->success([
            'data' => $queryBus->send(new GetProductDetailQuery($productId)),
        ]);
    }

    public function detail(int $productId, QueryBus $queryBus): JsonResponse
    {
        return $this->success([
            'data' => $queryBus->send(new GetProductDetailQuery($productId)),
        ]);
    }
}
