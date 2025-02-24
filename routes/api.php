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

    Route::prefix('utilities')->group(function () {
        Route::get('/sites', [UtilitiesController::class, 'getSites']);
        Route::get('/floors', [UtilitiesController::class, 'getFloors']);
        Route::get('/blocks', [UtilitiesController::class, 'getBlocks']);
        Route::get('/departments', [UtilitiesController::class, 'getDepartments']);
    });

});
