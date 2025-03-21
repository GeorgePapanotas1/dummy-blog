<?php

namespace App\Services\Posts\Internal;

use App\Dto\Common\Queries\SortQuery;
use App\Dto\Posts\Forms\CreatePostCategoryForm;
use App\Dto\Posts\Forms\UpdatePostCategoryForm;
use App\Exceptions\Posts\PostCategoryNotCreatedException;
use App\Exceptions\Posts\PostCategoryNotDeletedException;
use App\Exceptions\Posts\PostCategoryNotUpdatedException;
use App\Models\PostCategory;
use App\Services\Common\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostCategoryCrudService extends BaseRepository
{
    protected static function getModel(): PostCategory
    {
        return new PostCategory;
    }

    public function query(): Builder
    {
        return static::getModel()::query();
    }

    public function all(): Collection
    {
        return static::getModel()::all();
    }

    /**
     * @throws ModelNotFoundException
     */
    public function findById(int $id): PostCategory
    {
        return static::getModel()->findOrFail($id);
    }

    /**
     * @throws PostCategoryNotCreatedException
     * @throws \Throwable
     */
    public function create(CreatePostCategoryForm $form): PostCategory
    {
        $postCategory = static::getModel()
            ->fill($form->toArray());

        throw_if(! $postCategory->save(), PostCategoryNotCreatedException::class);

        return $postCategory;
    }

    /**
     * @throws PostCategoryNotUpdatedException
     * @throws \Throwable
     */
    public function update(PostCategory $postCategory, UpdatePostCategoryForm $form): void
    {
        $updated = $postCategory->update($form->toArray());
        throw_if(! $updated, PostCategoryNotUpdatedException::class);
    }

    /**
     * @throws PostCategoryNotDeletedException
     * @throws \Throwable
     */
    public function delete(PostCategory $postCategory): void
    {
        $deleted = $postCategory->delete();
        throw_if(! $deleted, PostCategoryNotDeletedException::class);
    }
}
