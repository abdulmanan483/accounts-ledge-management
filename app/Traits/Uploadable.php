<?php

namespace App\Traits;

use App\Enums\Generic\MediaType;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

trait Uploadable
{
    // -----------------------------
    // Private helper to upload file
    // -----------------------------
    private function uploadFile(
        UploadedFile|string $file,
        ?string $oldFilePath = null,
        string $disk = 'public',
        string $directory = 'uploads',
        int $quality = 80,
        ?string $newFileName = null
    ): ?string {
        try {
            if ($oldFilePath && Storage::disk($disk)->exists($oldFilePath)) {
                Storage::disk($disk)->delete($oldFilePath);
            }

            $directory = rtrim($directory, '/');
            if (!Storage::disk($disk)->exists($directory)) {
                Storage::disk($disk)->makeDirectory($directory, 0755, true);
            }

            $originalExtension = 'dat';
            $mimeType = null;

            if ($file instanceof UploadedFile) {
                $originalExtension = strtolower($file->getClientOriginalExtension());
                $mimeType = $file->getMimeType();
            } elseif (is_string($file)) {
                $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $file);
                $originalExtension = match ($mime) {
                    'image/heic', 'image/heif' => 'heic',
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/gif' => 'gif',
                    'application/pdf' => 'pdf',
                    default => 'dat',
                };
                $mimeType = $mime;
            }

            $isImage = str_starts_with($mimeType ?? '', 'image');

            $newFileName = $isImage
                ? ($newFileName ?? Str::uuid()) . '.webp'
                : ($newFileName ?? Str::uuid()) . '.' . $originalExtension;

            $filePath = $directory . '/' . $newFileName;
            $fullPath = Storage::disk($disk)->path($filePath);

            if ($file instanceof UploadedFile) {
                if ($isImage) {
                    $manager = new ImageManager(new Driver());
                    $manager->read($file->getRealPath())->toWebp($quality)->save($fullPath);
                    $mimeType = 'image/webp';
                } else {
                    $file->storeAs($directory, $newFileName, $disk);
                }
            } elseif (is_string($file)) {
                Storage::disk($disk)->put($filePath, $file);
                $mimeType = mime_content_type($fullPath);
            }

            return $filePath;
        } catch (\Throwable $e) {
            \Log::error('File upload failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    // -----------------------------
    // Delete file helper
    // -----------------------------
    public function deleteFile(?string $filePath, string $disk = 'public'): bool
    {
        if (!$filePath) return false;

        try {
            if (Storage::disk($disk)->exists($filePath)) {
                return Storage::disk($disk)->delete($filePath);
            }
            return false;
        } catch (\Throwable $e) {
            \Log::error('File deletion failed', ['error' => $e->getMessage(), 'file' => $filePath]);
            return false;
        }
    }

    // -----------------------------
    // Polymorphic media relation
    // -----------------------------
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    // -----------------------------
    // Upload or update Media with type
    // -----------------------------
    /**
     * @param UploadedFile|string $file
     * @param Media|null $media
     * @param int|null $type MediaType enum value
     * @param string $directory
     * @param string $disk
     * @param int $quality
     * @param string|null $newFileName
     * @return Media|null
     */
    public function uploadMedia(
        UploadedFile|string $file,
        ?Media $media = null,
        ?MediaType $type = null,
        string $directory = 'uploads',
        string $disk = 'public',
        int $quality = 80,
        ?string $newFileName = null
    ): ?Media {
        try {
            $oldFilePath = $media?->file_path;

            $filePath = $this->uploadFile($file, $oldFilePath, $disk, $directory, $quality, $newFileName);
            if (!$filePath) return null;

            $fullPath = Storage::disk($disk)->path($filePath);
            $mimeType = mime_content_type($fullPath);
            $fileSize = is_file($fullPath) ? filesize($fullPath) : 0;

            $mediaData = [
                'file_name'  => basename($filePath),
                'file_path'  => $filePath,
                'mime_type'  => $mimeType,
                'file_size'  => $fileSize,
                'type'       => $type,
                'created_by' => auth()->id(),
            ];

            if ($media) {
                $media->update($mediaData);
                return $media;
            }
            return $this->media()->create($mediaData);

        } catch (\Throwable $e) {
            \Log::error('Upload Media failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    // -----------------------------
    // Delete Media record and file
    // -----------------------------
    public function deleteMedia(Media $media, string $disk = 'public'): bool
    {
        try {
            $fileDeleted = $this->deleteFile($media->file_path, $disk);
            $mediaDeleted = $media->delete();
            return $fileDeleted && $mediaDeleted;
        } catch (\Throwable $e) {
            \Log::error('Delete Media failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
