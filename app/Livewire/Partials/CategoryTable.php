<?php

namespace App\Livewire\Partials;

use App\Models\PostCategory;
use App\Services\Posts\PostCategoryService;
use App\Traits\Common\WithSorting;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryTable extends Component
{
    use WithSorting;
    use WithPagination;

    private readonly PostCategoryService $postCategoryService;
    public function boot(PostCategoryService $postCategoryService): void
    {
        $this->postCategoryService = $postCategoryService;
    }
    protected $listeners = ['refreshCategories' => '$refresh'];


    public function render(): View
    {
        $categories = $this->postCategoryService->indexCategories($this->getSorts());

        return view('livewire.partials.category-table', [
            'categories' => $categories,
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
        ]);
    }
}
