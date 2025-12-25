<?php
namespace App\Traits;

use App\Enums\Media\MediaType;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

trait Uploadable
{
    /**
     * Upload media file(s) and create a record in the media table.
     *
     * @param array|\Illuminate\Http\UploadedFile|string $files
     * @param string $path
     * @param string $disk ('public' or 'private')
     * @param string $type
     * @return array|Media|null
     */
    public function uploadMedia(array|string|\Illuminate\Http\UploadedFile $files, string $path = 'uploads', string $disk = 'public', int $quality = 70, ?string $newFileName = null )
    {
        $uploadedMedia = [];

        // Normalize to array
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            $repo = app(\App\Repositories\MediumRepository::class);
            $media = $repo->uploadMedia($file, $disk, $path, $quality,$newFileName);
            // if ($media) {
                // $media->type = $type;
                // $media->save();
                $uploadedMedia[] = $media;
            // }
        }

        // Return single Media if only one file uploaded
        return count($uploadedMedia) === 1 ? $uploadedMedia[0] : $uploadedMedia;
    }

    /**
     * Delete media file and remove the record from the DB.
     *
     * @param int|Media $media
     * @param string $disk
     * @return bool
     */
    public function deleteMedia($media, string $disk = 'public'): bool
    {
        if (is_int($media)) {
            $media = $this->media()->find($media);
        }

        if (! $media) return false;

        // Delete file from storage
        if (Storage::disk($disk)->exists($media->file_path)) {
            Storage::disk($disk)->delete($media->file_path);
        }

        return $media->delete();
    }

    /**
     * Get full media URL.
     *
     * @param string|Media $media
     * @param string $disk
     * @return string|null
     */
    public function getMediaUrl($media, string $disk = 'public'): ?string
    {
        $filePath = $media instanceof Media ? $media->file_path : $media;

        if (! $filePath) return null;

        if (Storage::disk($disk)->exists($filePath)) {
            return Storage::disk($disk)->url($filePath);
        }

        return null;
    }

    /**
     * Relationship: A model can have multiple media files.
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
