<?php

namespace App\Repositories;

use App\Models\Media;
use App\Interfaces\MediumInterface;
use App\Repositories\BaseRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MediumRepository extends BaseRepository implements MediumInterface
{
    public function __construct(Media $model)
    {
        parent::__construct($model);
    }

    /**
     * Upload a file and save as Media
     */
    public function uploadMedia(
        UploadedFile|string $file,
        string $disk = 'public',
        string $directory = 'uploads',
        int $quality = 70,
        ?string $newFileName = null
    ): ?Media {
        try {
            $directory = rtrim($directory, '/');
            if (!Storage::disk($disk)->exists($directory)) {
                Storage::disk($disk)->makeDirectory($directory, 0755, true);
            }

            $originalExtension = 'dat';
            if ($file instanceof UploadedFile) {
                $originalExtension = strtolower($file->getClientOriginalExtension());
            } elseif (is_string($file)) {
                $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $file);
                $originalExtension = match ($mime) {
                    'image/heic', 'image/heif' => 'heic',
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    default => 'dat',
                };
            }

            $newFileName = ($newFileName ?? Str::uuid()) . '.' . $originalExtension;
            $filePath = $directory . '/' . $newFileName;
            $fullPath = Storage::disk($disk)->path($filePath);

            $manager = new ImageManager(new Driver());

            if ($file instanceof UploadedFile) {
                $mimeType = $file->getMimeType();
                $fileSize = $file->getSize();

                if (str_starts_with($mimeType, 'image') && !in_array($originalExtension, ['heic', 'heif'])) {
                    $manager->read($file->getRealPath())->toJpeg()->save($fullPath);
                    $mimeType = 'image/jpeg';
                    $originalExtension = 'jpg';
                } else {
                    $file->storeAs($directory, $newFileName, $disk);
                }
            } elseif (is_string($file)) {
                Storage::disk($disk)->put($filePath, $file);
                $fileSize = strlen($file);
                $mimeType = mime_content_type($fullPath);
            }

            // Save DB record
            return $this->model->create([
                'file_name'  => $newFileName,
                'file_path'  => $filePath,
                'mime_type'  => $mimeType ?? null,
                'file_size'  => $fileSize ?? 0,
                'created_by' => auth()->id(),
            ]);

        } catch (\Throwable $e) {
            \Log::error('Media upload failed', ['error' => $e->getMessage()]);
            return null;
        }
    }
}
