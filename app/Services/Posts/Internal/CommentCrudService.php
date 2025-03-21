<?php

namespace App\Services\Posts\Internal;

use App\Dto\Posts\Forms\CreateCommentForm;
use App\Exceptions\Posts\CommentNotCreatedException;
use App\Models\Comment;
use App\Services\Common\BaseRepository;

class CommentCrudService extends BaseRepository
{
    protected static function getModel(): Comment
    {
        return new Comment;
    }

    /**
     * @throws CommentNotCreatedException
     * @throws \Throwable
     */
    public function create(CreateCommentForm $form): Comment
    {
        $comment = static::getModel()
            ->fill($form->toArray());

        throw_if(! $comment->save(), CommentNotCreatedException::class);

        return $comment;
    }
}
