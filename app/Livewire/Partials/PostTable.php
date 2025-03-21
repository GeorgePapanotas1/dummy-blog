<?php

namespace App\Livewire\Partials;

use App\Models\Post;
use App\Services\Posts\PostService;
use App\Traits\Common\WithSorting;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class PostTable extends Component
{
    use WithSorting;
    use WithPagination;

    private readonly PostService $postService;
    public function boot(PostService $postService): void
    {
        $this->postService = $postService;
    }
    protected $listeners = ['refreshPosts' => '$refresh'];

    public function render(): View
    {
        $posts = $this->postService->indexUserPosts($this->getSorts(), Auth::user()->id);

        return view('livewire.partials.post-table', [
            'posts' => $posts,
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
        ]);
    }
}
