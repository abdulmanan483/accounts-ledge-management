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

    /**
     * Create a new user with optional roles and file uploads.
     */
    public function create(array $data): User
    {
        $user = $this->model->newInstance();

        // Handle file uploads
        $data = $this->handleFileUploads($user, $data);

        // Create user
        $user->fill($data)->save();

        // Attach roles if provided
        if (!empty($data['roles'])) {
            $user->roles()->sync($data['roles']);
        }

        return $user;
    }

    /**
     * Update an existing user with optional file uploads and roles.
     */
    public function update(int $id, array $data): User
    {
        $user = $this->find($id);

        // Handle file uploads
        $data = $this->handleFileUploads($user, $data);

        // Update user data
        $user->fill($data)->save();

        // Sync roles if provided
        if (array_key_exists('roles', $data)) {
            $user->roles()->sync($data['roles'] ?? []);
        }

        return $user;
    }

    /**
     * Check if an email is available (optionally ignoring a specific user ID).
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
     * Helper to handle file uploads for a user
     */
    private function handleFileUploads(User $user, array $data): array
    {
        // Map of fields to upload paths and media types
        $fileFields = [
            'profile_picture' => [
                'path' => config('constants.profile_picture_path'),
                'type' => MediaType::PROFILE_PICTURE
            ],
        ];

        foreach ($fileFields as $field => $options) {
            if (!empty($data[$field])) {
                // Find existing media if available
                $existingMedia = $user->media()->where('type', $options['type'])->first();

                $media = $user->uploadMedia(
                    $data[$field],
                    $existingMedia,
                    $options['type'],
                    $options['path'],
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

        return $data;
    }
}
