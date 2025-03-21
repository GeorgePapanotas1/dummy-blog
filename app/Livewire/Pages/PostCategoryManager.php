<?php

namespace App\Livewire\Pages;

use App\Constants\PostCategoriesColumns;
use App\Dto\Posts\Forms\CreatePostCategoryForm;
use App\Dto\Posts\Forms\UpdatePostCategoryForm;
use App\Exceptions\Posts\PostCategoryNotCreatedException;
use App\Exceptions\Posts\PostCategoryNotUpdatedException;
use App\Models\PostCategory;
use App\Services\Posts\PostCategoryService;
use App\Traits\Common\WithSorting;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class PostCategoryManager extends Component
{
    use WithSorting;

    public string $name = '';

    public ?int $editId = null;

    public bool $showCreateModal = false;

    public bool $showEditModal = false; // New modal state

    private readonly PostCategoryService $postCategoryService;

    public function boot(
        PostCategoryService $postCategoryService
    ): void {
        $this->postCategoryService = $postCategoryService;
    }

    protected $listeners = [
        'editCategory' => 'openEditModal',
        'confirmDelete' => 'deleteCategory',
    ];

    public function createCategory(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('post_categories', 'name')],
        ]);

        try {
            $this->postCategoryService->create(
                new CreatePostCategoryForm($this->name)
            );
            session()->flash('success', 'Post category created successfully.');

        } catch (PostCategoryNotCreatedException $e) {
            session()->flash('fail', 'Post category could not be created.');

        } catch (\Throwable $e) {
            session()->flash('fail', $e->getMessage());
        }

        $this->reset('name');
        $this->dispatch('close-modal');
        $this->dispatch('refreshCategories');

    }

    public function updateCategory(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('post_categories', 'name')->ignore($this->editId)],
        ]);

        try {
            $postCategory = $this->postCategoryService->findById($this->editId);

            $this->postCategoryService->update(
                $postCategory,
                UpdatePostCategoryForm::fromArray([
                    PostCategoriesColumns::NAME => $this->name,
                ]
                ));

            session()->flash('success', 'Post category updated successfully.');
        } catch (PostCategoryNotUpdatedException $e) {
            session()->flash('fail', 'Post could not be updated.');
        } catch (\Throwable $exception) {
            session()->flash('fail', $exception->getMessage());
        }

        $this->reset(['name', 'editId']);
        $this->dispatch('close-edit-modal');
        $this->dispatch('refreshCategories');
    }

    public function deleteCategory(PostCategory $category): void
    {
        try {
            $this->postCategoryService->delete($category);
            session()->flash('success', 'Post Category deleted successfully.');

        } catch (PostCategoryNotUpdatedException $exception) {
            session()->flash('fail', 'Post could not be deleted.');
        } catch (\Throwable $exception) {
            session()->flash('fail', $exception->getMessage());
        }

        $this->dispatch('refreshCategories');
    }

    #[\Livewire\Attributes\Computed]
    public function categories(): LengthAwarePaginator
    {
        return $this->postCategoryService->indexCategories($this->getSorts());
    }

    public function openCreateModal(): void
    {
        $this->showCreateModal = true;
    }

    public function openEditModal($categoryId): void
    {
        $category = $this->postCategoryService->findById($categoryId);

        $this->editId = $category->id;
        $this->name = $category->name;
        $this->showEditModal = true;
    }

    public function render(): View
    {
        return view('livewire.pages.dashboard.post-category-manager');
    }
}
