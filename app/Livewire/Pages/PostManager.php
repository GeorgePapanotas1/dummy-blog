<?php

namespace App\Livewire\Pages;

use App\Constants\PostsColumns;
use App\Dto\Posts\Forms\CreatePostForm;
use App\Dto\Posts\Forms\UpdatePostForm;
use App\Exceptions\Common\AuthorizedException;
use App\Exceptions\Posts\PostNotCreatedException;
use App\Exceptions\Posts\PostNotUpdatedException;
use App\Models\Post;
use App\Services\Posts\PostCategoryService;
use App\Services\Posts\PostService;
use App\Traits\Common\WithSorting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PostManager extends Component
{
    use WithSorting;

    public string $title = '';

    public string $content = '';

    public ?int $category_id = null;

    public ?int $editId = null;

    public bool $showCreateModal = false;

    public bool $showEditModal = false;

    private readonly PostService $postService;

    private readonly PostCategoryService $postCategoryService;

    public function boot(
        PostService $postService,
        PostCategoryService $postCategoryService
    ): void {
        $this->postService = $postService;
        $this->postCategoryService = $postCategoryService;
    }

    protected $listeners = [
        'editPost' => 'openEditModal',
        'confirmDeletePost' => 'deletePost',
    ];

    public function createPost(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'exists:post_categories,id'],
        ]);

        try {
            $this->postService->create(
                CreatePostForm::fromArray([
                    PostsColumns::TITLE => $this->title,
                    PostsColumns::CONTENT => $this->content,
                    PostsColumns::CATEGORY_ID => $this->category_id,
                    PostsColumns::USER_ID => Auth::id(),
                ]
                ));

            session()->flash('success', 'Post created successfully.');

        } catch (PostNotCreatedException $exception) {
            session()->flash('fail', 'Post could not be created.');
        } catch (\Throwable $e) {
            session()->flash('fail', $e->getMessage());
        }

        $this->reset(['title', 'content', 'category_id']);
        $this->dispatch('close-modal');
        $this->dispatch('refreshPosts');
    }

    public function updatePost(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'exists:post_categories,id'],
        ]);

        try {

            $post = $this->postService->findById($this->editId);

            $this->postService->update(
                $post,
                UpdatePostForm::fromArray([
                    PostsColumns::TITLE => $this->title,
                    PostsColumns::CONTENT => $this->content,
                    PostsColumns::CATEGORY_ID => $this->category_id,
                ]
                ));

            session()->flash('success', 'Post updated successfully.');

        } catch (AuthorizedException $e) {
            session()->flash('fail', $e->getMessage());
        } catch (PostNotUpdatedException $exception) {
            session()->flash('fail', 'Post could not be updated.');
        } catch (\Throwable $exception) {
            session()->flash('fail', $exception->getMessage());
        }

        $this->reset(['title', 'content', 'category_id', 'editId']);
        $this->dispatch('close-edit-modal');
        $this->dispatch('refreshPosts');

    }

    public function deletePost(Post $post): void
    {
        try {
            $this->postService->delete($post);
            session()->flash('success', 'Post deleted successfully.');

        } catch (AuthorizedException $e) {
            session()->flash('fail', $e->getMessage());
        } catch (PostNotUpdatedException $exception) {
            session()->flash('fail', 'Post could not be deleted.');
        } catch (\Throwable $exception) {
            session()->flash('fail', $exception->getMessage());
        }

        $this->dispatch('refreshPosts');
    }

    #[Computed]
    public function posts(): LengthAwarePaginator
    {
        return $this->postService->indexPosts($this->getSorts());
    }

    #[Computed]
    public function categories(): Collection
    {
        return $this->postCategoryService->all();
    }

    public function openCreateModal(): void
    {
        $this->reset(['title', 'content', 'category_id']);
        $this->showCreateModal = true;
    }

    public function openEditModal(Post $post): void
    {
        $this->editId = $post->id;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->category_id = $post->category_id;
        $this->showEditModal = true;
    }

    public function render(): View
    {
        return view('livewire.pages.dashboard.post-manager');
    }
}
