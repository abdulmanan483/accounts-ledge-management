<?php

use Illuminate\Support\Facades\Crypt;

function secure_file_url($path)
{
// Get the file extension
    $extension = pathinfo($path, PATHINFO_EXTENSION);

// Encrypt the path
    $encrypted = urlencode(Crypt::encryptString($path));

// Append extension at the end
    $secure_url = route('secure.file', $encrypted . '.' . $extension);

    return $secure_url;
}
