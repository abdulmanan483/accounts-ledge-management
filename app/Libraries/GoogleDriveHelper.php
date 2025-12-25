<?php

namespace App\Libraries;

class GoogleDriveHelper
{
    /**
     * Extract the file ID from a Google Drive URL.
     *
     * @param string $url
     * @return string|null
     */
    public static function extractFileId($url)
    {
        // Check for /d/ format
        if (preg_match('/\/d\/(.*?)\//', $url, $matches)) {
            return $matches[1] ?? null;
        }

        // Check for ?id= format
        if (preg_match('/id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1] ?? null;
        }

        return null;
    }
}
