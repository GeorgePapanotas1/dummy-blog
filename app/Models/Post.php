<?php

namespace App\Models;

use App\Constants\PostsColumns;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeWithSearch(Builder $builder, string $search): Builder
    {
        return $builder->where(PostsColumns::TITLE, 'like', "%{$search}%")
            ->orWhere(PostsColumns::CONTENT, 'like', "%{$search}%");
    }

    public function scopeOfUser(Builder $builder, int $userId): Builder
    {
        return $builder->where(PostsColumns::USER_ID, $userId);
    }
}
