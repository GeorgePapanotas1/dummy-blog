<?php

namespace App\Services\Users\Internal;

use App\Models\User;
use App\Services\Common\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserCrudService extends BaseRepository
{
    protected static function getModel(): Model
    {
        return new User;
    }

    public function all(): Collection
    {
        return static::getModel()::all();
    }
}
