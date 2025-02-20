<?php

namespace Database\Seeders;

use DB;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrCreate(['key' => 'mail_driver'         ], ['value' => 'smtp'                   ]);
        Setting::updateOrCreate(['key' => 'mail_host'           ], ['value' => 'smtp.gmail.com'         ]);
        Setting::updateOrCreate(['key' => 'mail_port'           ], ['value' => '587'                    ]);
        Setting::updateOrCreate(['key' => 'mail_username'       ], ['value' => 'ishfaq.alvi.33@gmail.com']);
        Setting::updateOrCreate(['key' => 'mail_password'       ], ['value' => 'htzqtlapvgxvspmy'       ]);
        Setting::updateOrCreate(['key' => 'mail_encryption'     ], ['value' => 'tls'                    ]);
        Setting::updateOrCreate(['key' => 'mail_from_address'   ], ['value' => 'ishfaq.alvi.33@gmail.com']);
        Setting::updateOrCreate(['key' => 'mail_from_name'      ], ['value' => 'YourAppName'            ]);
    }
}
