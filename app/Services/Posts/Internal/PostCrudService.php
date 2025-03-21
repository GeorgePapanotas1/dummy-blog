<?php

namespace App\Services\Posts\Internal;

use App\Constants\PostsColumns;
use App\Dto\Posts\Forms\CreatePostForm;
use App\Dto\Posts\Forms\UpdatePostForm;
use App\Dto\Posts\Queries\IndexPostsQuery;
use App\Exceptions\Posts\PostNotCreatedException;
use App\Exceptions\Posts\PostNotDeletedException;
use App\Exceptions\Posts\PostNotUpdatedException;
use App\Models\Post;
use App\Services\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostCrudService extends BaseRepository
{
    protected static function getModel(): Post
    {
        return new Post;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function findById(int $id): Post
    {
        return static::getModel()->findOrFail($id);
    }

    public function query(): Builder
    {
        return static::getModel()::query();
    }

    public function getPostsOfUserQuery(int $userId): Builder
    {
        return static::getModel()::ofUser($userId);
    }

    /**
     * @throws PostNotCreatedException
     * @throws \Throwable
     */
    public function create(CreatePostForm $form): Post
    {
        $post = static::getModel()
            ->fill($form->toArray());

        throw_if(! $post->save(), PostNotCreatedException::class);

        return $post;
    }

    /**
     * @throws PostNotUpdatedException
     * @throws \Throwable
     */
    public function update(Post $post, UpdatePostForm $form): void
    {
        $updated = $post->update($form->toArray());

        throw_if(! $updated, PostNotUpdatedException::class);
    }

    /**
     * @throws PostNotDeletedException
     * @throws \Throwable
     */
    public function delete(Post $post): void
    {
        $deleted = $post->delete();
        throw_if(! $deleted, PostNotDeletedException::class);
    }

    public function queryPosts(IndexPostsQuery $query): Builder
    {
        return static::getModel()
            ->query()
            ->when($query->categoryFilter, fn (Builder $builder) => $builder->where(PostsColumns::CATEGORY_ID, $query->categoryFilter))
            ->when($query->userFilter, fn (Builder $builder) => $builder->where(PostsColumns::USER_ID, $query->userFilter))
            ->when($query->search, fn (Builder $builder) => $builder->withSearch($query->search))
            ->orderBy($query->sort->sortBy, $query->sort->sortDirection->value);
    }
}
