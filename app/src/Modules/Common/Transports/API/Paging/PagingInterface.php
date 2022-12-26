<?php

declare(strict_types=1);

namespace Modules\Common\Transports\API\Paging;

use Illuminate\Contracts\Pagination\Paginator;

interface PagingInterface
{
    public static function fromPaginator(Paginator $paginator): self;

    public function getResponseKey(): string;

    public function toArray(): array;
}
