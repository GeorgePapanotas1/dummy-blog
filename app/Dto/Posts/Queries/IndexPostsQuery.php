<?php

namespace App\Dto\Posts\Queries;

use App\Dto\Common\Queries\SortQuery;

class IndexPostsQuery
{
    public function __construct(
        public SortQuery $sort,
        public ?int $categoryFilter,
        public ?int $userFilter,
        public ?string $search
    ) {}
}
