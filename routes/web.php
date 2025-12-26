<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return ucfirst(env('APP_NAME')) . ':' . env('APP_URL') . ' RUNNING';
});
\Illuminate\Support\Facades\Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
