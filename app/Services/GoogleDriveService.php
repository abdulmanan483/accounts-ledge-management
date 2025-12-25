<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Exception;
use Illuminate\Support\Facades\Storage;

class GoogleDriveService
{
    protected $driveService;

    public function __construct()
    {
        $this->driveService = new Drive($this->getClient());
    }

    private function getClient()
    {
        $client = new Client();
        $client->setApplicationName('Google Drive Service');
        $client->setScopes([Drive::DRIVE]);
        $client->setAuthConfig(public_path('credentials.json'));
        $client->setAccessType('offline');
        return $client;
    }

    public function setFilePermissions($fileId, $type = 'anyone', $role = 'reader')
    {
        try {
            $permission = new \Google\Service\Drive\Permission([
                'type' => $type,
                'role' => $role,
            ]);
            return $this->driveService->permissions->create($fileId, $permission);
        } catch (Exception $e) {
            info(['permissionError',$e->getMessage()]);
            // Handle exceptions
            return null;
        }
    }

    public function downloadFile($fileId, $localPath)
    {
        try {
             // Create the directory if it doesn't exist
            if (!Storage::exists(dirname($localPath))) {
                Storage::makeDirectory(dirname($localPath), 0755, true); // Create recursively with permissions
            }
            $content = $this->getFileContent($fileId);
            Storage::put($localPath, $content);
            return $localPath;
        } catch (Exception $e) {
            info(['downloadError',$e->getMessage()]);
            // Handle exceptions
            return null;
        }
    }
    public function getFileContent($fileId)
    {
        try {
            $file = $this->driveService->files->get($fileId, ['alt' => 'media']);
            $content = $file->getBody()->getContents();
            return $content;
        } catch (Exception $e) {
            info(['downloadError',$e->getMessage()]);
            // Handle exceptions
            return null;
        }
    }
}
