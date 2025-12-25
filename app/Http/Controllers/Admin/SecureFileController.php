<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SecureFileController extends Controller
{
    public function show(Request $request,$file_path)
    {
        $file_path = Crypt::decryptString(urldecode($file_path));
        // Ensure user is authenticated
        if (!Auth::check()) {
            abort(403, 'Unauthorized access');
        }

        // Define allowed folders (Add more as needed)
        // $allowedFolders = [
        //     'profile_pictures',
        //     'cnic_front',
        //     'cnic_back',
        //     'documents',
        // ];

        // // Validate the requested folder
        // if (!in_array($folder, $allowedFolders)) {
        //     abort(403, 'Unauthorized folder access');
        // }

        // Define the full path to the requested file
        // $path = storage_path("app/".$file_path);
        $path = Storage::disk('local')->path($file_path);
        // Check if the file exists
        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        // Ensure the authenticated user is authorized to view this file (Customize logic here)
        // if (!$this->isUserAuthorized($folder, $filename)) {
        //     abort(403, 'Unauthorized file access');
        // }

        // Return the file with proper headers
        return response()->file($path, [
            'Content-Type' => mime_content_type($path),
            'Cache-Control' => 'private, max-age=3600',
        ]);
    }

    /**
     * Check if the user is authorized to view the requested file.
     */
    private function isUserAuthorized($folder, $filename)
    {
        $user = Auth::user();

        // Check ownership for profile pictures
        if ($folder === 'profile_pictures' && $user->profile_picture !== $filename) {
            return false;
        }

        // Check ownership for CNIC images
        if ($folder === 'cnic_front' && $user->cnic_front !== $filename) {
            return false;
        }

        if ($folder === 'cnic_back' && $user->cnic_back !== $filename) {
            return false;
        }

        // Allow access for other document types (if required)
        return true;
    }
}
