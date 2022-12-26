<?php

namespace Modules\Product\Repositories;

use Modules\Common\Models\StateGettableInterface;
use Modules\Common\Repositories\FullTextSearchRepository\AbstractElasticsearchRepository;

final class ElasticsearchProductRepository extends AbstractElasticsearchRepository implements ProductRepositoryInterface
{
    public function __construct(StateGettableInterface $model)
    {
        $this->model = $model;
    }
}
