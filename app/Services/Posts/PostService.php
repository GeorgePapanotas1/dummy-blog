<?php

namespace App\Services\Posts;

use App\Constants\AppConstants;
use App\Constants\PostsColumns;
use App\Dto\Common\Queries\SortQuery;
use App\Dto\Posts\Forms\CreatePostForm;
use App\Dto\Posts\Forms\UpdatePostForm;
use App\Dto\Posts\Queries\IndexPostsQuery;
use App\Exceptions\Common\AuthorizedException;
use App\Exceptions\Posts\PostNotCreatedException;
use App\Exceptions\Posts\PostNotDeletedException;
use App\Exceptions\Posts\PostNotUpdatedException;
use App\Models\Post;
use App\Services\Posts\Authorization\PostAuthorizationService;
use App\Services\Posts\Internal\PostCrudService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class PostService
{
    public function __construct(
        private PostCrudService $postsCrudService,
        private PostAuthorizationService $postAuthorizationService
    ) {}

    /**
     * @throws ModelNotFoundException
     */
    public function findById(int $id): Post
    {
        return $this->postsCrudService->findById($id);
    }

    /**
     * @throws PostNotCreatedException|\Throwable
     */
    public function create(CreatePostForm $form): Post
    {
        return $this->postsCrudService->create($form);
    }

    /**
     * @throws PostNotUpdatedException
     * @throws AuthorizedException
     * @throws \Throwable
     */
    public function update(Post $post, UpdatePostForm $form): void
    {
        if (! $this->postAuthorizationService->canEdit($post)) {
            throw new AuthorizedException('You do not have permission to edit this post.', 401);
        }

        $this->postsCrudService->update($post, $form);
    }

    /**
     * @throws \Throwable
     * @throws PostNotDeletedException
     * @throws AuthorizedException
     */
    public function delete(Post $post): void
    {
        if (! $this->postAuthorizationService->canDelete($post)) {
            throw new AuthorizedException('You do not have permission to delete this post.', 401);
        }

        $this->postsCrudService->delete($post);
    }

    public function filterPosts(IndexPostsQuery $postsQuery): LengthAwarePaginator
    {
        return $this->postsCrudService
            ->queryPosts($postsQuery)
            ->paginate(AppConstants::PAGINATION_SIZE);
    }

    public function indexUserPosts(SortQuery $sortQuery, int $userId): LengthAwarePaginator
    {
        return $this->postsCrudService->getPostsOfUserQuery($userId)
            ->withCount('comments')
            ->orderBy($sortQuery->sortBy, $sortQuery->sortDirection->value)
            ->paginate(AppConstants::PAGINATION_SIZE);
    }

    public function indexPosts(SortQuery $sortQuery): LengthAwarePaginator
    {
        return $this->postsCrudService->query()
            ->tap(fn ($query) => $sortQuery->sortBy ? $query->orderBy($sortQuery->sortBy, $sortQuery->sortDirection->value) : $query)
            ->paginate(AppConstants::PAGINATION_SIZE);
    }
}
