<?php

declare(strict_types=1);

namespace Modules\Common\Mixins;

use AllowDynamicProperties;
use Closure;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use JeroenG\Explorer\Application\Results;
use JeroenG\Explorer\Domain\Syntax\Terms;
use JeroenG\Explorer\Infrastructure\Scout\ElasticEngine;
use Modules\Common\Exceptions\DefaultException;
use Modules\Common\Filters\AbstractElasticSearchFilter;
use Modules\Common\ValueObjects\AbstractValueObject;

/**
 * @method ElasticEngine engine()
 * @method int getTotalCount(Results $results)
 *
 * @property array $must
 * @property array $should
 * @property array $filter
 * @property $query
 * @property AbstractValueObject $model
 *
 * The data return by the engine is an array and then mapped back to Eloquent model by querying the DB.
 * We manually map the array data to SearchableModel here. Using AutoMapper most of the time to get rid of boilerplate.
 */
#[AllowDynamicProperties] final class ScoutBuilderMacros implements ScoutBuilderMacrosInterface
{
    public function getData(): Closure
    {
        return fn () => $this->engine()->search($this)->get();
    }

    public function paginateData(): Closure
    {
        return function (int $perPage = 10, string $pageName = 'page', int $page = 1) {
            $page = $page ?: Paginator::resolveCurrentPage($pageName);

            $results = $this->engine()->paginate($this, $perPage, $page);

            return Container::getInstance()->makeWith(LengthAwarePaginator::class, [
                'items' => $results->get(),
                'total' => $this->getTotalCount($results),
                'perPage' => $perPage,
                'currentPage' => $page,
                'options' => [
                    'path' => Paginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ],
            ])?->appends('query', $this->query);
        };
    }

    public function applyFilters(): Closure
    {
        return function (AbstractElasticSearchFilter $filters) {
            $this->must = $filters->must;
            $this->should = $filters->should;
            $this->filter = $filters->filter;

            return $this;
        };
    }

    /**
     * @throws DefaultException
     */
    private function whereIn(): Closure
    {
        throw new DefaultException('Not implemented');
    }

    public function whereIns(): Closure
    {
        return function (string $field, array $values) {
            $boolQuery = new Terms($field, array_map(static fn ($value) => (string) $value, $values));

            $this->must[] = $boolQuery;

            return $this;
        };
    }
}
