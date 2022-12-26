<?php

namespace Modules\Product\Queries;

use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\Enums\ProductSortBy;
use Modules\Product\Enums\ProductSortDirection;
use Modules\Product\ValueObjects\ProductFilters;
use Modules\Product\ValueObjects\ProductPaging;
use Modules\Product\ValueObjects\ProductSorts;

final class GetProductsQuery extends AbstractValueObject
{
    public readonly ProductFilters $filters;

    public readonly string $search;

    public readonly ProductSorts $sorts;

    public readonly ProductPaging $paging;

    public static function fromArray(array $data): self
    {
        $static = new self();

        $static->filters = ProductFilters::fromArray($data['filters'] ?? []);

        $static->search = $data['search'] ?? '';

        $static->sorts = new ProductSorts(
            sortBy: ProductSortBy::fromName($data['sort']['sortBy'] ?? ProductSortBy::PRODUCT_ID->name),
            direction: ProductSortDirection::fromName($data['sort']['direction'] ?? ProductSortDirection::DESC->name),
        );

        $static->paging = new ProductPaging(
            currentPage: $data['page']['currentPage'] ?? 1,
            perPage: $data['page']['perPage'] ?? 10,
        );

        return $static;
    }
}
