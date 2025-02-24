<?php

namespace App\Http\Controllers\Admin;

use Image;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Artisan;


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
        return view('admin.settings.index');
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
