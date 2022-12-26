<?php

declare(strict_types=1);

namespace Modules\Common\Mixins;

interface ScoutBuilderMacrosInterface
{
    public function getData();

    public function paginateData();

    public function applyFilters();

    public function whereIns();
}
