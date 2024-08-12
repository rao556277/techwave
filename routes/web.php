<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;

Route::get('password/reset/{token}', function () {
    return view('auth.reset');
})->name('password.reset');

Route::post('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'reset']);

Route::get('/', function () {
    return view('welcome');
});
