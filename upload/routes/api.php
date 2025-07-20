<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ContentController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('auth.register');
    Route::post('login', 'login')->name('auth.login');
    Route::post('logout', 'logout')->middleware(['jwt-auth'])
        ->name('auth.logout');
});

Route::middleware(['jwt-auth'])->group(function () {
    Route::prefix('profile')->controller(UserController::class)
        ->group(function () {
            Route::get('', 'show')->name('profile.show');
            Route::put('', 'update')->name('profile.update');
        });

    Route::prefix('content')->controller(ContentController::class)
        ->group(function () {
            Route::get('', 'index')->name('content.index');
            Route::post('', 'store')->name('content.store');

            Route::prefix('{id}')->group(function () {
                Route::get('', 'show')->name('content.show');
                Route::put('update', 'update')->name('content.update');
                Route::delete('delete', 'destroy')->name('content.delete');
            });
        });
});
