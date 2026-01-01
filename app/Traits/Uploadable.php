<?php

namespace App\Traits;

use App\Enums\Generic\MediaType;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait Uploadable
{
    /**
     * Upload media for this model and replace old one if exists (per type)
     *
     * @param UploadedFile|string $file
     * @param string $type Media type (enum: profile_picture, cnic_front, cnic_back, etc)
     * @param string $path Upload path
     * @param string $disk Storage disk
     * @param int $quality Image quality
     * @return Media|null
     */
    public function uploadMedia(
        UploadedFile|string $file,
        MediaType $type,
        string $path,
        string $disk = 'public',
        int $quality = 70
    ): ?Media {

        $repo = app(\App\Repositories\MediumRepository::class);

        // 1️⃣ Find existing media of this type for this model
        $existing = $this->media()->where('type', $type)->first();

        // 2️⃣ Upload new media using your existing repo logic
        $newMedia = $repo->uploadMedia($file, $disk, $path, $quality);

        if (! $newMedia) return null;

        // 3️⃣ Delete old media if exists
        if ($existing) {
            if (Storage::disk($disk)->exists($existing->file_path)) {
                Storage::disk($disk)->delete($existing->file_path);
            }
            $existing->delete();
        }

        // 4️⃣ Attach new media to this model
        $newMedia->mediable()->associate($this);
        $newMedia->type = $type;
        $newMedia->save();

        return $newMedia;
    }

    /**
     * Polymorphic media relation
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
