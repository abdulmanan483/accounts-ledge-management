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

class ProcessExternalCnicBack implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mobileNo;
    protected $cnicBackUrl;

    public function __construct($mobileNo, $cnicBackUrl)
    {
        $this->mobileNo   = $mobileNo;
        $this->cnicBackUrl = $cnicBackUrl;
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

            $fileId = GoogleDriveHelper::extractFileId($this->cnicBackUrl);

            if (!$fileId) {
                \Log::warning('INVALID GOOGLE DRIVE URL', [
                    'url' => $this->cnicBackUrl
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
                config('constants.cnic_back_path'),
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
                'cnic_back' => $media->file_path
            ]);

        } catch (\Throwable $e) {

            \Log::critical('PROCESS CNIC BACK JOB FAILED', [
                'mobile' => $this->mobileNo,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString()
            ]);
        }
    }
}
