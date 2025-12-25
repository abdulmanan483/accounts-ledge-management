<?php

namespace App\Jobs;

use App\Libraries\GoogleDriveHelper;
use App\Models\User;
use App\Services\GoogleDriveService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessExternalCnicFront implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mobileNo;
    protected $cnicFrontUrl;

    public function __construct($mobileNo, $cnicFrontUrl)
    {
        $this->mobileNo = $mobileNo;
        $this->cnicFrontUrl = $cnicFrontUrl;
    }

    public function handle(): void
    {
        try {
            $user = User::where('mobile_no', $this->mobileNo)->first();

            if (!$user) {
                \Log::warning('USER NOT FOUND', [
                    'mobile' => $this->mobileNo
                ]);
                return;
            }

            $fileId = GoogleDriveHelper::extractFileId($this->cnicFrontUrl);

            if (!$fileId) {
                \Log::warning('INVALID GOOGLE DRIVE URL', [
                    'url' => $this->cnicFrontUrl
                ]);
                return;
            }

            $drive = new GoogleDriveService();
            $drive->setFilePermissions($fileId);

            $binary = $drive->getFileContent($fileId);

            if (!$binary) {
                \Log::error('GOOGLE DRIVE DOWNLOAD FAILED', [
                    'fileId' => $fileId
                ]);
                return;
            }

            $media = $user->uploadMedia(
                $binary,
                config('constants.cnic_front_path'),
                'local',
                70,
                $fileId
            );

            if (!$media) {
                \Log::error('MEDIA SAVE FAILED', [
                    'mobile' => $this->mobileNo,
                    'fileId' => $fileId
                ]);
                return;
            }

            $user->update([
                'cnic_front' => $media->file_path
            ]);
            \Log::info('CNIC FRONT UPDATED', [
                    'media' => $media,
                    'user' => $user
                ]);
        } catch (\Throwable $e) {

            \Log::critical('PROCESS CNIC JOB FAILED', [
                'mobile' => $this->mobileNo,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString()
            ]);
        }
    }
}
