<?php

namespace Modules\Common\Transports\API\Concerns;

use AutoMapperPlus\MapperInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Modules\Common\Cache\CacheableTrait;
use Modules\Common\Cache\CacheKey\CacheKeyBuilderInterface;
use Modules\Common\Cache\CacheProviderInterface;
use Modules\Common\Services\ServiceInterface;
use Modules\Common\Transportation\API\Paging\PagingInterface;
use Modules\Common\Transportation\API\Response\SuccessResponseInterface;
use Modules\Common\Transportation\API\ViewModel\ViewModelInterface;

trait CachedApiFoundationTrait
{
    use CacheableTrait;
    use APIFoundationTrait;

    public function responsePagination(
        DTOInterface $dto,
        ServiceInterface $service,
        PagingInterface $paging,
        MapperInterface $mapper,
        ViewModelInterface $viewModel
    ): JsonResponse {
        $this->setCacheProvider(app(CacheProviderInterface::class));
        $this->setCacheKeyBuilder(app(CacheKeyBuilderInterface::class));

        $cacheKey = $this->cacheKeyBuilder->build(
            $service::class.'_'.$mapper::class.'_'.$viewModel::class,
            $dto->toArray()
        );

        $rawResponse = $this->cacheProvider->remember(
            $cacheKey,
            function () use ($dto, $service, $paging, $mapper, $viewModel, $cacheKey) {
                Log::alert('Cache missed for '.$cacheKey);

                $responser = app(SuccessResponseInterface::class);

                $responser = $responser
                    ->setData($service->execute($dto))
                    ->setMapper($mapper)
                    ->setViewModel($viewModel)
                    ->setPaging($paging);

                return $responser->rawResponse();
            }
        );

        return response()->json($rawResponse);
    }

    public function responseItem(
        DTOInterface $dto,
        ServiceInterface $service,
        MapperInterface $mapper,
        ViewModelInterface $viewModel
    ): JsonResponse {
        $this->setCacheProvider(app(CacheProviderInterface::class));
        $this->setCacheKeyBuilder(app(CacheKeyBuilderInterface::class));

        $cacheKey = $this->cacheKeyBuilder->build(
            $service::class.'_'.$mapper::class.'_'.$viewModel::class,
            $dto->toArray()
        );

        $rawResponse = $this->cacheProvider->remember(
            $cacheKey,
            function () use ($dto, $service, $mapper, $viewModel, $cacheKey) {
                Log::alert('Cache missed for '.$cacheKey);

                $responser = app(SuccessResponseInterface::class);

                $responser = $responser
                    ->setData($service->execute($dto))
                    ->setMapper($mapper)
                    ->setViewModel($viewModel);

                return $responser->rawResponse();
            }
        );

        return response()->json($rawResponse);
    }
}
