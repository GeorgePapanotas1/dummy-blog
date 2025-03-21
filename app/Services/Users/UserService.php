<?php

namespace App\Services\Users;

use App\Services\Users\Internal\UserCrudService;
use Illuminate\Database\Eloquent\Collection;

readonly class UserService
{
    public function __construct(
        private UserCrudService $userCrudService
    ) {}

    public function all(): Collection
    {
        return $this->userCrudService->all();
    }
}
