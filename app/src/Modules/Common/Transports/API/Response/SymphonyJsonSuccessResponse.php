<?php

declare(strict_types=1);

namespace Modules\Common\Transports\API\Response;

use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Common\Services\ServiceInterface;
use Modules\Common\Transports\API\Paging\PagingInterface;
use Modules\Common\Transports\API\ViewModel\ViewModelInterface;
use Modules\Common\ValueObjects\AbstractValueObject;

final class SymphonyJsonSuccessResponse implements SuccessResponseInterface
{
    public function __construct(
        protected mixed $responseData = null,
        protected ?PagingInterface $paginationInfo = null,
        protected ?ViewModelInterface $viewModel = null,
        protected ?AbstractValueObject $requestToServiceDTO = null,
        protected ?ServiceInterface $service = null
    ) {
    }

    public function rawResponse(): mixed
    {
        if ($this->responseData instanceof Paginator) {
            $response = $this->getResponseFromPaginator();
        } elseif ($this->responseData instanceof ResourceCollection) {
            $response = $this->getResponseFromResourceCollection();
        } else {
            $response = $this->getResponseFromRaw();
        }

        return $response;
    }

    public function response(): JsonResponse
    {
        return response()->json($this->rawResponse());
    }

    protected function getResponseFromRaw(): mixed
    {
        if (null === $this->viewModel) {
            return $this->responseData;
        }

        $data = app('auto_mapper.mapper')->mapToObject($this->responseData, $this->viewModel)->toArray();

        return [
            'data' => $data,
        ];
    }

    protected function getResponseFromPaginator(): array
    {
        $response = [];

        $response['data'] = $this->responseData->getCollection()->map(
            function ($item) {
                if (null === $this->viewModel) {
                    return $item;
                }

                try {
                    return app('auto_mapper.mapper')->mapToObject($item, $this->viewModel)->toArray();
                } catch (Exception) {
                    return $item;
                }
            }
        )->all();

        $response[$this->paginationInfo->getResponseKey()] = $this->paginationInfo::fromPaginator(
            $this->responseData
        )->toArray();

        return $response;
    }

    protected function getResponseFromResourceCollection(): array|string
    {
        $this->responseData = $this->responseData->resource;

        if ($this->responseData instanceof Paginator) {
            return $this->getResponseFromPaginator();
        }

        return $this->getResponseFromRaw();
    }
}
