<?php

namespace App\Dto\Posts\Forms;

use App\Dto\Common\Forms\BaseForm;
use Illuminate\Support\Arr;

class UpdatePostForm extends BaseForm
{
    public function __construct(
        public ?string $title,
        public ?string $content,
        public ?int $category_id
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'title', ''),
            Arr::get($data, 'content', ''),
            Arr::get($data, 'category_id', 0)
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'category_id' => $this->category_id,
        ];
    }
}
