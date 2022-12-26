<?php

namespace Modules\Product\Transports\API\Paging;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Modules\Common\Transports\API\Paging\PagingInterface;
use RuntimeException;

final class ListProductsPaging implements PagingInterface
{
    private int $currentPage;

    private int $perPage;

    private int $lastPage;

    private int $total;

    public static function fromPaginator(Paginator $paginator): self
    {
        if (! $paginator instanceof LengthAwarePaginator) {
            throw new RuntimeException('Paginator must be instance of LengthAwarePaginator');
        }

        $static = new self();

        $static->currentPage = $paginator->currentPage();
        $static->perPage = $paginator->perPage();
        $static->lastPage = $paginator->lastPage();
        $static->total = $paginator->total();

        return $static;
    }

    public function toArray(): array
    {
        return [
            'currentPage' => $this->currentPage,
            'perPage' => $this->perPage,
            'lastPage' => $this->lastPage,
            'total' => $this->total,
        ];
    }

    public function getResponseKey(): string
    {
        return 'page';
    }
}
