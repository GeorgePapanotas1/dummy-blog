<?php

namespace App\Livewire\Pages;

use App\Dto\Posts\Queries\IndexPostsQuery;
use App\Services\Posts\PostCategoryService;
use App\Services\Posts\PostService;
use App\Services\Users\UserService;
use App\Traits\Common\WithSorting;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class IndexManager extends Component
{
    use WithPagination;
    use WithSorting;

    public string $search = '';

    public ?int $categoryFilter = null;

    public ?int $userFilter = null;

    private readonly PostService $postService;

    private readonly PostCategoryService $postCategoryService;

    private readonly UserService $userService;

    public function boot(
        PostService $postService,
        PostCategoryService $postCategoryService,
        UserService $userService
    ): void {
        $this->postService = $postService;
        $this->postCategoryService = $postCategoryService;
        $this->userService = $userService;
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedUserFilter(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {

        $posts = $this->postService->filterPosts(
            new IndexPostsQuery(
                $this->getSorts(),
                $this->categoryFilter,
                $this->userFilter,
                $this->search
            ));

        return view('livewire.pages.public.index-manager', [
            'posts' => $posts,
            'categories' => $this->postCategoryService->all(),
            'users' => $this->userService->all(),
        ])->layout('components.layouts.index', ['title' => 'All Posts']);
    }
}
