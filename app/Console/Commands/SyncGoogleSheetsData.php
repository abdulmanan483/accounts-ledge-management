<?php

namespace App\Console\Commands;

use App\Libraries\GoogleDriveHelper;
use App\Jobs\ProcessExternalCnicBack;
use App\Jobs\ProcessExternalCnicFront;
use App\Jobs\ProcessExternalProfilePicture;
use App\Models\User;
use App\Services\GoogleSheetsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SyncGoogleSheetsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:google-sheets-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync data from Google Sheets to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch data from Google Sheets
        $googleSheetsService = new GoogleSheetsService();
        $data = $googleSheetsService->readSheet();

        // Prepare data for bulk insertion
        $usersData = [];
        $phoneNumbers = [];
        $pattern = '/^(03[0-9]{9}|00923[0-9]{9}|\+923[0-9]{9})$/';

        // Iterate over each row, starting from index 1 to skip the headers
        foreach ($data as $index => $row) {
            if ($index != 0) {
                $timestamp = $row[0];
                $mobile_no = trim(str_replace(' ', '', $row[8]));
                $registration_datetime = date('Y-m-d H:i:s', strtotime($timestamp));
                $phoneNumbers[] = $mobile_no;
                $isPakistani = preg_match($pattern, $mobile_no) ? 1 : 0;

                $user = User::where('mobile_no', $mobile_no)->first();

                // Check if email already exists
                $email = isset($row[11]) ? trim($row[11]) : null;
                if ($email && User::where('email', $email)->exists()) {
                    $email = null; // Set to null if already exists
                }
                else{
                    \Log::info($row);
                }

                $updateData = [
                    'form_no' => $index,
                    'registration_date' => $registration_datetime,
                    'name' => $row[1],
                    'email' => $email,
                    'cnic' => isset($user) && empty($user->cnic) ? @$row[12] ?? '' : @$user->cnic ?? '',
                    'gender' => $row[2] == 'Male' ? 1 : 0,
                    'external_profile_pic' => $row[3],
                    'external_cnic_front' => $row[4],
                    'external_cnic_back' => $row[5],
                    'city' => $row[6],
                    'country' => $row[7],
                    'educational_qualifications' => $row[9],
                    'skills' => $row[10],
                    'is_pakistani' => $isPakistani,
                    'data_source' => 1,
                ];

                if ($user && $user->form_no != $index) {
                    $user->update($updateData);
                } elseif ($user && empty($user->cnic)) {
                    $user->update(['cnic' => @$row[12] ?? '']);
                } elseif (!$user) {
                    User::updateOrCreate(['mobile_no' => $mobile_no], $updateData);
                }
            }
        }


        // $usersWithMissingImages = User::where(function ($query) {
        //     $query->where('profile_picture', '')
        //         ->orWhereColumn('profile_picture', 'external_profile_pic');
        // })
        //     ->orWhere(function ($query) {
        //         $query->where('cnic_front', '')
        //             ->orWhereColumn('cnic_front', 'external_cnic_front');
        //     })
        //     ->orWhere(function ($query) {
        //         $query->where('cnic_back', '')
        //             ->orWhereColumn('cnic_back', 'external_cnic_back');
        //     })
        //     ->get();

        $usersWithMissingImages = User::where(function ($q) {
            $q->whereNotNull('external_profile_pic')->where('external_profile_pic', '!=', '')
                ->orWhereNotNull('external_cnic_front')->where('external_cnic_front', '!=', '')
                ->orWhereNotNull('external_cnic_back')->where('external_cnic_back', '!=', '');
        })->get();

        // Dispatch jobs for new users
        foreach ($usersWithMissingImages as $userData) {
            $mobileNo = $userData['mobile_no'];
            $id = $userData['id'];


            // PROFILE PHOTO
            $profilePictureUrl = $userData['external_profile_pic'];
            $fileId = GoogleDriveHelper::extractFileId($profilePictureUrl);
            $profilePicturePath = config('constants.profile_picture_path') . $fileId . '.jpg';
            if ($this->isFileInvalid($profilePicturePath, $userData['profile_picture'], $profilePictureUrl)) {
                $this->info('--------------------------------------------------------');
                $this->info('PROFILE PICTURE is invalid:');
                $this->info("Path: $profilePicturePath");
                $this->info("URL: $profilePictureUrl");
                $this->info("User : {$userData['profile_picture']}");
                dispatch(new ProcessExternalProfilePicture($mobileNo, $profilePictureUrl));
            } else {
                User::where('mobile_no', $mobileNo)->update(['profile_picture' => $profilePicturePath]);
            }

            // CNIC FRONT
            $cnicFrontUrl = $userData['external_cnic_front'];
            $fileId = GoogleDriveHelper::extractFileId($cnicFrontUrl);
            $cnicFrontPath = config('constants.cnic_front_path') . $fileId . '.jpg';

            if ($this->isFileInvalid($cnicFrontPath, $userData['cnic_front'], $cnicFrontUrl)) {

                // if(!in_array($userData['mobile_no'],['+971568580987']))
                //     dd($cnicFrontPath, $cnicFrontUrl, $fileId,$this->isFileInvalid($cnicFrontPath, $userData['cnic_front'], $cnicFrontUrl),$userData->toArray());
                // if($mobileNo == '03066221319'){
                $this->info('--------------------------------------------------------');
                $this->info('CNIC FRONT is invalid:');
                $this->info("Path: $cnicFrontPath");
                $this->info("URL: $cnicFrontUrl");
                $this->info("UserCnicFront : {$userData['cnic_front']}");
                $this->info("User : {$userData}");
                dispatch(new ProcessExternalCnicFront($mobileNo, $cnicFrontUrl));
                // }
            } else {
                // if($mobileNo == '03066221319'){
                //     dd($cnicFrontPath,$mobileNo);
                // }
                User::where('mobile_no', $mobileNo)->update(['cnic_front' => $cnicFrontPath]);
            }

            // CNIC BACK
            $cnicBackUrl = $userData['external_cnic_back'];
            $fileId = GoogleDriveHelper::extractFileId($cnicBackUrl);
            $cnicBackPath = config('constants.cnic_back_path') . $fileId . '.jpg';
            if ($this->isFileInvalid($cnicBackPath, $userData['cnic_back'], $cnicBackUrl)) {
                $this->info('--------------------------------------------------------');
                $this->info('CNIC BACK is invalid:');
                $this->info("Path: $cnicBackPath");
                $this->info("URL: $cnicBackUrl");
                $this->info("User : {$userData['cnic_back']}");
                dispatch(new ProcessExternalCnicBack($mobileNo, $cnicBackUrl));
            } else {
                User::where('mobile_no', $mobileNo)->update(['cnic_back' => $cnicBackPath]);
            }
        }

        $this->info('Data synchronized successfully.');
    }

    /**
     * Check if the file is invalid (doesn't exist, is empty, or is corrupted).
     *
     * @param string $filePath
     * @param string $databaseValue
     * @param string $urlValue
     * @return bool
     */
    protected function isFileInvalid($filePath, $databaseValue, $urlValue)
    {
        if (!Storage::disk('local')->exists($filePath) || $databaseValue == '' || $databaseValue == NULL || $urlValue == $databaseValue) {
            return true;
        }

        // Check if the file is not empty and not corrupted
        $fileSize = Storage::disk('local')->size($filePath);
        if ($fileSize <= 0) {
            Storage::disk('local')->delete($filePath);
            return true;
        }

        $fileContent = Storage::disk('local')->get($filePath);
        $image = @imagecreatefromstring($fileContent);
        if ($image === false) {
            Storage::disk('local')->delete($filePath);
            return true;
        }

        imagedestroy($image);
        return false;
    }
}
