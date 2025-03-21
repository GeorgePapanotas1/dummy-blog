<?php

namespace App\Dto\Posts\Forms;

use App\Constants\PostCategoriesColumns;
use App\Dto\Common\Forms\BaseForm;
use Illuminate\Support\Arr;

class CreatePostCategoryForm extends BaseForm
{
    public function __construct(
        public string $name,
    ) {}

    public function toArray(): array
    {
        return [
            PostCategoriesColumns::NAME => $this->name,
        ];
    }

    public static function fromArray(array $data): BaseForm
    {
        return new self(
            Arr::get($data, 'name', ''),
        );
    }
}
