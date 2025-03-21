<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    abstract protected static function getModel(): Model;
}
