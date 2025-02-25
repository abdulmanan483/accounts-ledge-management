<?php

namespace App\Http\Controllers\Admin;

use Image;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    function __construct()
    {
        $this->middleware('permission:settings-list',   ['only' => ['index']]);
        $this->middleware('permission:settings-save',   ['only' => ['save']]);
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
        $allSettings = settings();

        // Dynamically group settings by category based on key prefixes
        $settingsGroups = collect($allSettings)->mapWithKeys(function ($value, $key) {
            $groupKey = explode('_', $key)[0]; // Assuming group names are prefixes (e.g., mail_driver -> mail)
            return [$groupKey => $key];
        })->groupBy(function ($key) {
            return explode('_', $key)[0]; // Group settings by prefix
        })->map(function ($group) use ($allSettings) {
            return $group->map(function ($key) use ($allSettings) {
                return [
                    'key'   => $key,
                    'label' => ucwords(str_replace('_', ' ', $key)),
                    'type'  => $this->getFieldType($key), // Automatically determine input type
                    'options' => $this->getOptions($key), // For select fields
                    'value' => $allSettings[$key] ?? ''
                ];
            });
        });
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
                'ssl' => 'SSL'
            ],
            'app_status' => [
                'active' => 'Active',
                'inactive' => 'Inactive'
            ]
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

        foreach ($request->file() as $key => $file) {
            if ($image = $request->file($key)) {
                $filenametostore = uploadFile($image, 'settings');
                $data[] = ['key' => $key,'value' => $filenametostore];
            }
        }
        Setting::set($data);
        Artisan::call('optimize:clear');
        return redirect()->back()->with('success', 'Setting updated successfully.');
    }
}
