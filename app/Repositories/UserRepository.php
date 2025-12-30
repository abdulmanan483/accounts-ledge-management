<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserInterface;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
    public function isEmailAvailable(string $email, ?int $ignoreId = null): bool
    {
        $query = $this->model->where('email', $email);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }
        return !$query->exists();
    }
}
