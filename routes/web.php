<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('index');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');



Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'newUserAuth'], function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::put('update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    });

    Route::group(['middleware' => 'oldUserAuth'], function () {
        Route::get('process-registration', [AccountController::class, 'processRegistration'])->name('account.processRegistration');
        Route::get('/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');
        Route::get('/register', [AccountController::class, 'register'])->name('account.register');
    });
});
