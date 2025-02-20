<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Auther;
use App\Models\Tool;
use App\Models\Gallery;
use App\Models\Language;
use App\Models\JobApplication;
use App\Models\Feedback;
use App\Models\Comment;
use App\Models\Page;
use Illuminate\Routing\Controllers\Middleware;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public static function middleware(): array
{
    return [
        new Middleware('auth'),
    ];
}

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('admin.dashboard');
    }
}
