<?php

namespace App\Repositories;

use App\Enums\Generic\MediaType;
use App\Models\User;
use App\Interfaces\UserInterface;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
    public function update(int $id, array $data): User
    {
        $user = $this->find($id);
        // File uploads
        $file_paths = [
            'profile_picture' => config('constants.profile_picture_path'),
        ];

        foreach ($file_paths as $field => $path) {
            if (!empty($data[$field])) {
                switch ($field) {
                    case 'profile_picture':
                        $type = MediaType::PROFILE_PICTURE;
                        break;
                    default:
                        $type = MediaType::DEFAULT;
                        break;
                }

                $media = $user->uploadMedia(
                    $data[$field],
                    $type,
                    $path,
                    'local',
                    70
                );

                if ($media && isset($media->file_path)) {
                    $data[$field] = $media->file_path;
                }
             } else {
                // Prevent overwriting existing value with null
                unset($data[$field]);
            }
        }

        // Update user data
        $user->fill($data)->save();

        // Sync roles if provided
        if (array_key_exists('roles', $data)) {
            $user->roles()->sync($data['roles'] ?? []);
        }

        return $user;
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
