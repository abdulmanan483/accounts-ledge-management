<?php

namespace App\Traits;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

trait Uploadable
{
    // -----------------------------
    // Upload file (existing)
    // -----------------------------
    public function uploadFile(
        UploadedFile|string $file,
        ?string $oldFilePath = null,
        string $disk = 'public',
        string $directory = 'uploads',
        int $quality = 80,
        ?string $newFileName = null
    ): ?string {
        try {
            // Delete old file
            if ($oldFilePath && Storage::disk($disk)->exists($oldFilePath)) {
                Storage::disk($disk)->delete($oldFilePath);
            }

            // Ensure directory exists
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

            if ($isImage) {
                $newFileName = ($newFileName ?? Str::uuid()) . '.webp';
            } else {
                $newFileName = ($newFileName ?? Str::uuid()) . '.' . $originalExtension;
            }

            $filePath = $directory . '/' . $newFileName;
            $fullPath = Storage::disk($disk)->path($filePath);

            if ($file instanceof UploadedFile) {
                if ($isImage) {
                    $manager = new ImageManager(new Driver());
                    $manager->read($file->getRealPath())->toWebp()->save($fullPath);
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
    /**
     * Delete a file from storage
     *
     * @param string|null $filePath
     * @param string $disk
     * @return bool
     */
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


    /**
     * Polymorphic media relation
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
