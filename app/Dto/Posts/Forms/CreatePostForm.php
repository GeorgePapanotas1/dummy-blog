<?php

namespace App\Dto\Posts\Forms;

use App\Constants\PostsColumns;
use App\Dto\Common\Forms\BaseForm;
use Illuminate\Support\Arr;

class CreatePostForm extends BaseForm
{
    public function __construct(
        public string $title,
        public string $content,
        public int $category_id,
        public int $user_id,
    ) {}

    public function toArray(): array
    {
        return [
            PostsColumns::TITLE => $this->title,
            PostsColumns::CONTENT => $this->content,
            PostsColumns::CATEGORY_ID => $this->category_id,
            PostsColumns::USER_ID => $this->user_id,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'title', ''),
            Arr::get($data, 'content', ''),
            Arr::get($data, 'category_id', null),
            Arr::get($data, 'user_id', null),
        );
    }
}
