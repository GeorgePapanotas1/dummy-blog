<?php

namespace App\Livewire\Components;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class TableComponent extends Component
{
    use WithPagination;

    public $query;

    public $columns = [];

    public $perPage = 10;

    public $sortBy = 'created_at';

    public $sortDirection = 'asc';

    public function mount(Builder $query, array $columns, $perPage = 10)
    {
        $this->query = $query;
        $this->columns = $columns;
        $this->perPage = $perPage;
    }

    public function sort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function getRecordsProperty()
    {
        return $this->query
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.components.table-component', [
            'records' => $this->records,
            'columns' => $this->columns,
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
        ]);
    }
}
