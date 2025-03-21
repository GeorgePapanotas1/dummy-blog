<?php

namespace App\Dto\Common\Queries;

class PaginationQuery
{
    public function __construct(
        public int $perPage,
    ) {}
}
