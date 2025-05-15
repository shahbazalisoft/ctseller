<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/login', [AdminController::class, 'index'])->name('login');
Route::get('/login/{tab}', [AdminController::class, 'login'])->name('login');
Route::post('login_submit', [AdminController::class, 'submit'])->name('login_post');


Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'index');
    // Route::post('/login_submit', 'login')->name('login_post');
});


Route::get('admin/logout', [AdminController::class, 'logout'])->name('logout');
