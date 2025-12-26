<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\UtilitiesController;
use App\Http\Middleware\VerifyApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');




Route::group(['middleware' => VerifyApiToken::class, 'namespace'=>'App\Http\Controllers\API'], function(){
	/*
	|--------------------------------------------------------------------------
	| Public Routes
	|--------------------------------------------------------------------------
	*/
	Route::controller(AuthController::class)->prefix('auth')->group(function () {
    	Route::post('signup',			'signup'		);
    	Route::post('signin',			'signin'        );
    	Route::post('account_varify',   'accountVarify'	);
    	Route::post('forgot_password',  'forgotPass'	);
        Route::post('verify_otp',       'verifiOtp' 	);
        Route::post('reset_password',   'resetPass' 	);
	});
    Route::middleware(['auth:sanctum', VerifyApiToken::class])->group(function () {
        Route::prefix('utilities')->group(function () {
        });
        Route::get('/user-role-permissions', [AuthController::class, 'getRolePermissions']);
    });

});
