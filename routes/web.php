<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

// Route::get('/login/{tab}', [AdminController::class, 'login'])->name('login');
// Route::post('login_submit', [AdminController::class, 'submit'])->name('login_post');


Route::controller(LoginController::class)->group(function () {
    // Route::get('/admin', 'index');

    Route::get('login/{tab}', 'login')->name('login');
    Route::post('login_submit', 'submit')->name('login_post');
    Route::get('logout', 'logout')->name('logout');
    Route::get('/reload-captcha', 'reloadCaptcha')->name('reload-captcha');
    Route::get('/reset-password', 'reset_password_request')->name('reset-password');
    Route::post('/vendor-reset-password', 'vendor_reset_password_request')->name('vendor-reset-password');
    Route::get('/password-reset', 'reset_password')->name('change-password');
    Route::post('verify-otp', 'verify_token')->name('verify-otp');
    Route::post('reset-password-submit', 'reset_password_submit')->name('reset-password-submit');
    Route::get('otp-resent', 'otp_resent')->name('otp_resent');

});


// Route::get('admin/logout', [AdminController::class, 'logout'])->name('logout');
