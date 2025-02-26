<?php
namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultSettings = [
            // General Settings
            ['key' => 'site_title', 'name' => 'Site Title', 'type' => 'text', 'value' => config('app.name', 'Laravel Product Base'), 'tab' => 'General', 'section' => 'Site Info'],
            ['key' => 'site_logo', 'name' => 'Site Logo', 'type' => 'image', 'value' => 'uploads/logo.png', 'tab' => 'General', 'section' => 'Site Info'],
            ['key' => 'contact_email', 'name' => 'Contact Email', 'type' => 'text', 'value' => 'info@example.com', 'tab' => 'General', 'section' => 'Contact'],
            ['key' => 'maintenance_mode', 'name' => 'Maintenance Mode', 'type' => 'number', 'value' => '0', 'tab' => 'General', 'section' => 'Site Status'],

            // Mail Settings
            ['key' => 'mail_driver', 'name' => 'Mail Driver', 'type' => 'text', 'value' => config('mail.default', env('MAIL_MAILER', 'smtp')), 'tab' => 'Mail', 'section' => 'SMTP Configuration'],
            ['key' => 'mail_host', 'name' => 'Mail Host', 'type' => 'text', 'value' => config('mail.mailers.smtp.host', env('MAIL_HOST', 'smtp.gmail.com')), 'tab' => 'Mail', 'section' => 'SMTP Configuration'],
            ['key' => 'mail_port', 'name' => 'Mail Port', 'type' => 'number', 'value' => config('mail.mailers.smtp.port', env('MAIL_PORT', 587)), 'tab' => 'Mail', 'section' => 'SMTP Configuration'],
            ['key' => 'mail_username', 'name' => 'Mail Username', 'type' => 'text', 'value' => config('mail.mailers.smtp.username', env('MAIL_USERNAME', '')), 'tab' => 'Mail', 'section' => 'SMTP Configuration'],
            ['key' => 'mail_password', 'name' => 'Mail Password', 'type' => 'text', 'value' => config('mail.mailers.smtp.password', env('MAIL_PASSWORD', '')), 'tab' => 'Mail', 'section' => 'SMTP Configuration'],
            ['key' => 'mail_encryption', 'name' => 'Mail Encryption', 'type' => 'text', 'value' => config('mail.encryption', env('MAIL_ENCRYPTION', 'tls')), 'tab' => 'Mail', 'section' => 'SMTP Configuration'],
            ['key' => 'mail_from_address', 'name' => 'Mail From Address', 'type' => 'text', 'value' => config('mail.from.address', env('MAIL_FROM_ADDRESS', '')), 'tab' => 'Mail', 'section' => 'Sender Information'],
            ['key' => 'mail_from_name', 'name' => 'Mail From Name', 'type' => 'text', 'value' => config('mail.from.name', env('MAIL_FROM_NAME', config('app.name'))), 'tab' => 'Mail', 'section' => 'Sender Information'],

            // Location Settings
            ['key' => 'default_country_id', 'name' => 'Default Country', 'type' => 'dropdown', 'value' => '167', 'tab' => 'Location', 'section' => 'Defaults'],

            // // SAP Settings
            // ['key' => 'sap_url', 'name' => 'SAP URL', 'type' => 'text', 'value' => '', 'tab' => 'External API Integrations', 'section' => 'SAP'],
            // ['key' => 'sap_db', 'name' => 'SAP Database', 'type' => 'text', 'value' => '', 'tab' => 'External API Integrations', 'section' => 'SAP'],
            // ['key' => 'sap_username', 'name' => 'SAP Username', 'type' => 'text', 'value' => '', 'tab' => 'External API Integrations', 'section' => 'SAP'],
            // ['key' => 'sap_password', 'name' => 'SAP Password', 'type' => 'password', 'value' => '', 'tab' => 'External API Integrations', 'section' => 'SAP'],


        ];

        foreach ($defaultSettings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
        Artisan::call('optimize:clear');
    }
}
