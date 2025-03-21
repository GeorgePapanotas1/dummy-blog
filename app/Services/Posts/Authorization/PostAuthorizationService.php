<?php

namespace App\Services\Posts\Authorization;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class PostAuthorizationService
{
    public function canEdit(Post $post): bool
    {
        return Gate::allows('update', $post);
    }

    public function canDelete(Post $post): bool
    {
        return Gate::allows('delete', $post);
    }
}
