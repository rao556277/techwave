<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;



Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::post('register', [RegisterController::class, 'register']);
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('reset-password', [ForgotPasswordController::class, 'reset']);


Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
    Route::get('/profile', [AdminDashboardController::class, 'show']);

    //Class Routes
    Route::get('/classes', [ClassController::class, 'index']);
    Route::post('/classes', [ClassController::class, 'store']);
    Route::get('/classes/{id}', [ClassController::class, 'show']);
    Route::post('/classes/{id}/add-student', [ClassController::class, 'addStudent']);
    Route::get('/classes/{id}/edit', [ClassController::class, 'edit']);
    Route::put('/classes/{id}', [ClassController::class, 'update']);
    Route::delete('/classes/{id}', [ClassController::class, 'destroy']);
    //Instructor Routes
    Route::get('instructors', [InstructorController::class, 'index']);
    Route::post('instructors', [InstructorController::class, 'store']);
    Route::get('instructors/{id}', [InstructorController::class, 'show']);
    Route::put('instructors/{id}', [InstructorController::class, 'update']);
    Route::delete('instructors/{id}', [InstructorController::class, 'destroy']);
    //Student Routes
    Route::get('students', [StudentController::class, 'index']);
    Route::post('students', [StudentController::class, 'store']);
    Route::get('students/{id}', [StudentController::class, 'show']);
    Route::put('students/{id}', [StudentController::class, 'update']);
    Route::delete('students/{id}', [StudentController::class, 'destroy']);
    //User Routes
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::put('users/{user}', [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);
});

