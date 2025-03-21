<?php

namespace App\Dto\Posts\Forms;

use App\Constants\CommentsColumns;
use App\Dto\Common\Forms\BaseForm;
use Illuminate\Support\Arr;

class CreateCommentForm extends BaseForm
{
    public function __construct(
        public int $postId,
        public int $userId,
        public string $comment,
    ) {}

    public function toArray(): array
    {
        return [
            CommentsColumns::POST_ID => $this->postId,
            CommentsColumns::USER_ID => $this->userId,
            CommentsColumns::COMMENT => $this->comment,
        ];
    }

    public static function fromArray(array $data): BaseForm
    {
        return new self(
            Arr::get($data, 'post_id', ''),
            Arr::get($data, 'user_id', ''),
            Arr::get($data, 'comment', ''),
        );
    }
}
