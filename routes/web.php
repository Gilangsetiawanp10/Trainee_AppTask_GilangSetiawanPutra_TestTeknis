<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 

// Guest routes
Route::get('/', function () {
    return redirect('/login');
});

// User Authentication Routes
Auth::routes();

// Admin Authentication Routes
Route::group(['prefix' => 'admin'], function () {
    Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Auth\AdminLoginController@login');
    Route::post('logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    
    // Admin protected routes
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('dashboard', function () {
            return redirect('/trainee-tasks');
        })->name('admin.dashboard');
    });
});

// Protected routes (both admin and user)
Route::group(['middleware' => ['auth:admin,web']], function () {
    Route::resource('trainee-tasks', 'TraineeTaskController')->except(['show', 'destroy']);
    Route::get('trainee-tasks/data', 'TraineeTaskController@getData')->name('trainee-tasks.data');
    Route::patch('trainee-tasks/{id}/status', 'TraineeTaskController@updateStatus')->name('trainee-tasks.update-status');
    Route::delete('trainee-tasks/bulk-delete', 'TraineeTaskController@bulkDelete')->name('trainee-tasks.bulk-delete');
    Route::post('trainee-tasks/import', 'TraineeTaskController@import')->name('trainee-tasks.import');
    Route::get('trainee-tasks/export', 'TraineeTaskController@export')->name('trainee-tasks.export');
});

// User dashboard
Route::get('/home', function () {
    return redirect('/trainee-tasks');
})->name('home');
