<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ContentController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware(['jwt-auth']);
});

Route::middleware(['jwt-auth'])->group(function () {
    Route::prefix('profile')->controller(UserController::class)
        ->group(function () {
            Route::get('', 'show');
            Route::put('', 'update');
        });

    Route::prefix('content')->controller(ContentController::class)
        ->group(function () {
            Route::get('', 'index');
            Route::post('', 'store');

            Route::prefix('{id}')->group(function () {
                Route::get('', 'show');
                Route::put('update', 'update');
                Route::delete('delete', 'destroy');
            });
        });
});
