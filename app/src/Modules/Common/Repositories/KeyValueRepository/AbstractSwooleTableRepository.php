<?php

    declare(strict_types=1);

namespace Modules\Common\Repositories\KeyValueRepository;

    use Illuminate\Contracts\Cache\Repository;
    use Illuminate\Support\Facades\Cache;

    abstract class AbstractSwooleTableRepository implements KeyValueRepositoryInterface
    {
        protected Repository $store;

        public function __construct()
        {
            $this->store = Cache::store('octane');
        }

        public function getStore(): Repository
        {
            return $this->store;
        }
    }
