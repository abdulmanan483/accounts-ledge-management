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

class ProcessExternalProfilePicture implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mobileNo;
    protected $profilePictureUrl;

    public function __construct($mobileNo, $profilePictureUrl)
    {
        $this->mobileNo = $mobileNo;
        $this->profilePictureUrl = $profilePictureUrl;
    }

    public function handle(): void
    {
        try {
            $user = User::where('mobile_no', $this->mobileNo)->first();

            if (!$user) {
                \Log::warning('USER NOT FOUND (PROFILE PIC)', [
                    'mobile' => $this->mobileNo
                ]);
                return;
            }

            $fileId = GoogleDriveHelper::extractFileId($this->profilePictureUrl);

            if (!$fileId) {
                \Log::warning('INVALID GOOGLE DRIVE URL (PROFILE PIC)', [
                    'url' => $this->profilePictureUrl
                ]);
                return;
            }

            $drive = new GoogleDriveService();
            $drive->setFilePermissions($fileId);

            $binary = $drive->getFileContent($fileId);

            if (!$binary) {
                \Log::error('GOOGLE DRIVE DOWNLOAD FAILED (PROFILE PIC)', [
                    'fileId' => $fileId
                ]);
                return;
            }

            $media = $user->uploadMedia(
                $binary,
                config('constants.profile_picture_path'),
                'local',
                70,
                $fileId
            );

            if (!$media) {
                \Log::error('MEDIA SAVE FAILED (PROFILE PIC)', [
                    'mobile' => $this->mobileNo,
                    'fileId' => $fileId
                ]);
                return;
            }

            $user->update([
                'profile_picture' => $media->file_path
            ]);

        } catch (\Throwable $e) {

            \Log::critical('PROCESS PROFILE PICTURE JOB FAILED', [
                'mobile' => $this->mobileNo,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString()
            ]);
        }
    }
}
