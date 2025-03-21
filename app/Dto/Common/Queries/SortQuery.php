<?php

namespace App\Dto\Common\Queries;

use App\Constants\Enums\SortDirection;

class SortQuery
{
    public function __construct(
        public ?string $sortBy,
        public ?SortDirection $sortDirection,
    ) {}
}
