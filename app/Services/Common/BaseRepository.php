<?php

namespace App\Services\Common;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    abstract protected static function getModel(): Model;
}
