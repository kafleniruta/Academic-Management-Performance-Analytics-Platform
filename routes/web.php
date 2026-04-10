<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MarkController;

// Redirect root to login or dashboard
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    
    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
        Route::get('dashboard', [HomeController::class, 'adminDashboard'])->name('dashboard');
    });
    
    // Student routes
    Route::resource('students', \App\Http\Controllers\Web\StudentController::class)->names('students');
    Route::get('students/my/courses', [\App\Http\Controllers\Web\StudentController::class, 'myCourses'])->name('students.mycourses');
    Route::get('students/my/marks', [\App\Http\Controllers\Web\StudentController::class, 'myMarks'])->name('students.mymarks');
    
    // Course routes
    Route::resource('courses', \App\Http\Controllers\Web\CourseController::class)->names('courses');
    Route::get('courses/available-teachers', [\App\Http\Controllers\Web\CourseController::class, 'getAvailableTeachers'])->name('courses.teachers');
    
    // Marks routes
    Route::resource('marks', \App\Http\Controllers\Web\MarkController::class)->names('marks');
    Route::get('marks/statistics', [\App\Http\Controllers\Web\MarkController::class, 'statistics'])->name('marks.statistics');
});
