<?php

declare(strict_types=1);

namespace Modules\Common\DTOs;

use Modules\Common\Filters\FilterInterface;
use Modules\Common\ValueObjects\AbstractValueObject;

abstract class AbstractFilterDTO extends AbstractValueObject
{
    public function __construct(
        protected ?FilterInterface $filters = null,
        protected int $perPage = 10,
        protected int $page = 1,
        protected string $orderBy = 'id',
        protected string $direction = 'desc',
        protected array $columns = ['*'],
        protected string $pageName = 'page',
        protected string $search = '',
    ) {
    }

    public function toArray(): array
    {
        return [
            'filters' => $this->filters->toArray(),
            'perPage' => $this->perPage,
            'page' => $this->page,
            'orderBy' => $this->orderBy,
            'direction' => $this->direction,
            'columns' => $this->columns,
            'pageName' => $this->pageName,
            'search' => $this->search,
        ];
    }
}
