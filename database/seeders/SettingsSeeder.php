<?php
namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrInsert(['key' => 'mail_driver'], ['value' => 'smtp']);
        Setting::updateOrInsert(['key' => 'mail_host'], ['value' => 'smtp.gmail.com']);
        Setting::updateOrInsert(['key' => 'mail_port'], ['value' => '587']);
        Setting::updateOrInsert(['key' => 'mail_username'], ['value' => 'ishfaq.alvi.33@gmail.com']);
        Setting::updateOrInsert(['key' => 'mail_password'], ['value' => 'htzqtlapvgxvspmy']);
        Setting::updateOrInsert(['key' => 'mail_encryption'], ['value' => 'tls']);
        Setting::updateOrInsert(['key' => 'mail_from_address'], ['value' => 'ishfaq.alvi.33@gmail.com']);
        Setting::updateOrInsert(['key' => 'mail_from_name'], ['value' => 'YourAppName']);
    }
}
