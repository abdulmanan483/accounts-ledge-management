<?php
namespace App\Traits;

use App\Enums\Media\MediaType;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

trait MediaTrait
{
    /**
     * Upload media file and create a record in the media table.
     */
    public function uploadMedia(array $files, $path = 'uploads', $type = MediaType::MEDIA)
    {
        $uploadedMedia = [];

        foreach ($files as $file) {
            if ($file instanceof \Illuminate\Http\UploadedFile) {
                // Handle file upload
                $filePath = $file->store($path, 'public');
                $fileName = $file->getClientOriginalName();
                $mimeType = $file->getClientMimeType();
                $fileSize = $file->getSize();
            } elseif (is_string($file) && preg_match('/^data:image\/(\w+);base64,/', $file, $matches)) {
                // Handle base64 image
                $imageData = substr($file, strpos($file, ',') + 1);
                $imageData = base64_decode($imageData);
                $extension = $matches[1] ?? 'png';
                $fileName  = uniqid() . '.' . $extension;
                $filePath  = $path . '/' . $fileName;
                Storage::disk('public')->put($filePath, $imageData);
                $mimeType = 'image/' . $extension;
                $fileSize = strlen($imageData);
            } else {
                continue; // Skip invalid data
            }

            // Create media record in DB linked to this model
            $media = $this->media()->create([
                'file_path' => $filePath,
                'file_name' => $fileName,
                'mime_type' => $mimeType,
                'file_size' => $fileSize,
                'type'      => $type,
            ]);

            $uploadedMedia[] = $media;
        }

        return $uploadedMedia; // Return array of uploaded media records
    }

    /**
     * Delete media file and remove the record from the DB.
     */
    public function deleteMedia($mediaId)
    {
        $media = $this->media()->find($mediaId);
        if (! $media) {
            return false;
        }

        // Delete file from storage
        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        // Delete from DB
        return $media->delete();
    }

    /**
     * Get full media URL.
     */
    public function getMediaUrl($filePath)
    {
        return Storage::disk('public')->url($filePath);
    }

    /**
     * Relationship: A model can have multiple media files.
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
