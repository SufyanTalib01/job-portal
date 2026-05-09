<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('index');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs');
Route::get('/job/details/{id}', [JobController::class, 'jobDetails'])->name('jobDetails');



Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'newUserAuth'], function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::put('update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::post('/updateprofilepicture', [AccountController::class, 'updateProfilePicture'])->name('account.updateProfilePicture');
        Route::get('/create-job', [AccountController::class, 'createJob'])->name('account.createJob');
        Route::post('/save-job', [AccountController::class, 'saveJob'])->name('account.saveJob');
        Route::get('/my-jobs', [AccountController::class, 'myJobs'])->name('account.myJobs');
        Route::get('/edit-job/{id}', [AccountController::class, 'editJob'])->name('account.editJob');
        Route::put('/update-job/{id}', [AccountController::class, 'updateJob'])->name('account.updateJob');
        Route::delete('/delete-job/{id}', [AccountController::class, 'deleteJob'])->name('account.deleteJob');
        Route::post('/apply-job', [AccountController::class, 'applyJob'])->name('account.applyJob');
        Route::get('/my-job-applications', [AccountController::class, 'myJobApplications'])->name('account.myJobApplications');
        Route::delete('/job-applied-delete/{id}', [AccountController::class, 'AppliedJobdelete'])->name('account.AppliedJobdelete');
    });

    Route::group(['middleware' => 'oldUserAuth'], function () {
        Route::get('/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');
        Route::get('/register', [AccountController::class, 'register'])->name('account.register');
        Route::post('process-registration', [AccountController::class, 'processRegistration'])->name('account.processRegistration');
    });
});
