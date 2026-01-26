<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserOldRepository extends BaseRepository implements UserInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    // -------------------------------
    // Override BaseRepository functions if required
    // -------------------------------

    /**
     * Create a user and assign roles
     * Overrides base create to handle roles
     */
    public function create(array $attributes): User
    {
        $user = parent::create($attributes);

        if (!empty($attributes['roles'])) {
            $roles = array_filter(array_map('intval', $attributes['roles']));
            $user->assignRole($roles);
        }

        return $user;
    }

    /**
     * Update a user and its roles
     * Overrides base update to handle roles
     */
    public function update(int $id, array $attributes): User
    {
        $user = $this->find($id);

        if (empty($attributes['password'])) {
            $attributes = Arr::except($attributes, ['password']);
        }

        $user->update($attributes);

        if (!empty($attributes['roles'])) {
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            $roles = array_filter(array_map('intval', $attributes['roles']));
            $user->assignRole($roles);
        }

        return $user;
    }

    // -------------------------------
    // User-specific functions (not in BaseRepository)
    // -------------------------------

    /**
     * Check if email is available
     */
    public function isEmailAvailable(string $email, ?int $ignoreId = null): bool
    {
        $query = $this->model->where('email', $email);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }
        return !$query->exists();
    }

    /**
     * Verify user's old password
     */
    public function verifyPassword(int $userId, string $oldPassword): bool
    {
        $user = $this->find($userId);
        return Hash::check($oldPassword, $user->password);
    }

    /**
     * Update profile (name, email, password optional)
     */
    public function updateProfile(int $userId, array $attributes): User
    {
        $user = $this->find($userId);

        if (!empty($attributes['new_password'])) {
            $attributes['password'] = $attributes['new_password'];
        }

        $attributes = Arr::except($attributes, ['new_password', 'confirm_password', 'old_password']);

        $user->update($attributes);

        return $user;
    }

    /**
     * Delete user safely (cannot delete self or super-admin)
     */
    public function safeDelete(int $userId, int $currentUserId): bool
    {
        $user = $this->find($userId);

        if ($user->id === 1 || $user->id === $currentUserId) {
            return false; // cannot delete
        }

        return $user->delete();
    }
}
