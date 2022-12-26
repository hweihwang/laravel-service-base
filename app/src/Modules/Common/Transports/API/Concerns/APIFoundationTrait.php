<?php

declare(strict_types=1);

namespace Modules\Common\Transports\API\Concerns;

use Illuminate\Http\JsonResponse;
use Modules\Common\Services\ServiceInterface;
use Modules\Common\Transports\API\Paging\PagingInterface;
use Modules\Common\Transports\API\Response\SymphonyJsonErrorResponse;
use Modules\Common\Transports\API\Response\SymphonyJsonSuccessResponse;
use Modules\Common\Transports\API\ViewModel\ViewModelInterface;
use Modules\Common\ValueObjects\AbstractValueObject;

trait APIFoundationTrait
{
//    use AuthorizesRequests;
//    use DispatchesJobs;
//    use ValidatesRequests;

    public function success(
        mixed $data,
        ?PagingInterface $paging = null,
        ?ViewModelInterface $viewModel = null,
        ?AbstractValueObject $requestToServiceDTO = null,
        ?ServiceInterface $mainService = null
    ): JsonResponse {
        return (new SymphonyJsonSuccessResponse(
            responseData: $data,
            paginationInfo: $paging,
            viewModel: $viewModel,
            requestToServiceDTO: $requestToServiceDTO,
            service: $mainService,
        ))->response();
    }

    public function error(
        string $message,
        string $key,
        int $statusCode
    ): JsonResponse {
        return (new SymphonyJsonErrorResponse(
            message: $message,
            key: $key,
            statusCode: $statusCode,
        ))->response();
    }

    public function responsePagination(
        AbstractValueObject $dto,
        ServiceInterface $service,
        PagingInterface $paging,
        ViewModelInterface $viewModel
    ): JsonResponse {
        return $this->success(
            data: $service->execute($dto),
            paging: $paging,
            viewModel: $viewModel,
            requestToServiceDTO: $dto,
            mainService: $service
        );
    }

    public function responseItem(
        AbstractValueObject $dto,
        ServiceInterface $service,
        ViewModelInterface $viewModel
    ): JsonResponse {
        return $this->success(
            data: $service->execute($dto),
            viewModel: $viewModel,
            requestToServiceDTO: $dto,
            mainService: $service
        );
    }
}
