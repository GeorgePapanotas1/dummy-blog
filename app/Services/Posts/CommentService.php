<?php

namespace App\Services\Posts;

use App\Dto\Posts\Forms\CreateCommentForm;
use App\Exceptions\Posts\CommentNotCreatedException;
use App\Models\Comment;
use App\Services\Posts\Internal\CommentCrudService;

readonly class CommentService
{
    public function __construct(
        private CommentCrudService $commentCrudService
    ) {}

    /**
     * @throws CommentNotCreatedException|\Throwable
     */
    public function create(CreateCommentForm $form): Comment
    {
        return $this->commentCrudService->create($form);
    }
}
