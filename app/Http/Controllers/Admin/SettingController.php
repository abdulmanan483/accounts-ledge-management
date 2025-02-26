<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:settings-list', ['only' => ['index']]);
        $this->middleware('permission:settings-save', ['only' => ['save']]);
    }
//     public static function middleware(): array
// {
//     return [
//         new Middleware('permission:settings-list', only: ['index']),
//         new Middleware('permission:settings-save', only: ['save']),
//     ];
// }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
{
    // Get all cached settings
    $settings = settings(); // Assuming this fetches settings from the database

    $settingsGroups = [];

foreach ($settings as $setting) {
    // Ensure `tab` and `section` exist before using them
    $tab = $setting->tab ?? 'General';
    $section = $setting->section ?? 'Default';

    // Initialize tab and section if not already set
    if (!isset($settingsGroups[$tab])) {
        $settingsGroups[$tab] = [];
    }
    if (!isset($settingsGroups[$tab][$section])) {
        $settingsGroups[$tab][$section] = [];
    }

    // Add setting to the appropriate tab/section
    $settingsGroups[$tab][$section][$setting->key] = $setting;
}
    // Debugging output

    // Pass grouped settings to the view
    return view('admin.settings.index', compact('settingsGroups'));
}




    // Dynamically determine field type
    private function getFieldType($key)
    {
        if (Str::contains($key, ['password', 'secret', 'key'])) {
            return 'password';
        } elseif (Str::contains($key, ['status', 'type', 'mode'])) {
            return 'select';
        } else {
            return 'text';
        }
    }

    // Define options for select fields
    private function getOptions($key)
    {
        $options = [
            'mail_encryption' => [
                'tls' => 'TLS',
                'ssl' => 'SSL',
            ],
            'app_status'      => [
                'active'   => 'Active',
                'inactive' => 'Inactive',
            ],
        ];

        return $options[$key] ?? [];
    }

    /**
     * Clear a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearCache()
    {
        Artisan::call('optimize:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        return redirect()->back()->with('success', 'Optimization completed! successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $data = [];

        if ($request->values) {
            foreach ($request->input('values') as $key => $value) {
                $data[] = ['key' => $key, 'value' => $value];
            }
        }

        // foreach ($request->file() as $key => $file) {
        //     if ($image = $request->file($key)) {
        //         $filenametostore = uploadFile($image, 'settings');
        //         $data[]          = ['key' => $key, 'value' => $filenametostore];
        //     }
        // }
        Setting::setSetting($data);
        return redirect()->back()->with('success', 'Setting updated successfully.');
    }
}
