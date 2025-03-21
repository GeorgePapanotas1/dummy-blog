<?php

namespace App\Services\Posts;

use App\Constants\AppConstants;
use App\Dto\Common\Queries\SortQuery;
use App\Dto\Posts\Forms\CreatePostCategoryForm;
use App\Dto\Posts\Forms\UpdatePostCategoryForm;
use App\Exceptions\Posts\PostCategoryNotCreatedException;
use App\Exceptions\Posts\PostCategoryNotDeletedException;
use App\Exceptions\Posts\PostCategoryNotUpdatedException;
use App\Models\PostCategory;
use App\Services\Posts\Internal\PostCategoryCrudService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class PostCategoryService
{
    public function __construct(
        private PostCategoryCrudService $postCategoriesCrudService
    ) {}

    public function all(): Collection
    {
        return $this->postCategoriesCrudService->all();
    }

    /**
     * @throws ModelNotFoundException
     */
    public function findById(int $id): PostCategory
    {
        return $this->postCategoriesCrudService->findById($id);
    }

    /**
     * @throws PostCategoryNotCreatedException|\Throwable
     */
    public function create(CreatePostCategoryForm $form): PostCategory
    {
        return $this->postCategoriesCrudService->create($form);
    }

    /**
     * @throws PostCategoryNotUpdatedException
     * @throws \Throwable
     */
    public function update(PostCategory $postCategory, UpdatePostCategoryForm $form): void
    {
        $this->postCategoriesCrudService->update($postCategory, $form);
    }

    /**
     * @throws \Throwable
     * @throws PostCategoryNotDeletedException
     */
    public function delete(PostCategory $postCategory): void
    {
        $this->postCategoriesCrudService->delete($postCategory);
    }

    public function indexCategories(SortQuery $sortQuery): LengthAwarePaginator
    {
        return $this->postCategoriesCrudService->query()
            ->tap(fn ($query) => $sortQuery->sortBy ? $query->orderBy($sortQuery->sortBy, $sortQuery->sortDirection->value) : $query)
            ->paginate(AppConstants::PAGINATION_SIZE);
    }
}
