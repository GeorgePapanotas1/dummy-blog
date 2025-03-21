<?php

namespace App\Traits\Common;

use App\Constants\Enums\SortDirection;
use App\Dto\Common\Queries\SortQuery;

trait WithSorting
{
    public string $sortBy = 'created_at';

    public string $sortDirection = 'desc';

    public function sort($column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function getSorts(): SortQuery
    {
        return new SortQuery($this->sortBy, SortDirection::from($this->sortDirection));
    }
}
