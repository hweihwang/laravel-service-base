<?php

    declare(strict_types=1);

namespace Modules\Common\Repositories\KeyValueRepository;

    use Illuminate\Contracts\Cache\Repository;

    interface KeyValueRepositoryInterface
    {
        public function getStore(): Repository;
    }
