<?php

return [
    'profile_picture_path'=>'profile_images/',
    'cnic_front_path'=>'cnic/front/',
    'cnic_back_path'=>'cnic/back/',
    'channel_ids' => env('YOUTUBE_CHANNEL_IDS',''),
    'per_page' => [
        ['value' => '10', 'name' => '10'],
        ['value' => '20', 'name' => '20'],
        ['value' => '50', 'name' => '50'],
        ['value' => '100', 'name' => '100'],
        ['value' => '200', 'name' => '200'],
    ]
];
