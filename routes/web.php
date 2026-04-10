<?php

// Add this root route
Route::get('/', function () {
    return redirect('/login');
});

use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;

use App\Http\Controllers\Teacher\TeacherDashboardController as TeacherDashboard;
use App\Http\Controllers\Teacher\TeacherMarkController as TeacherMark;
use App\Http\Controllers\Teacher\TeacherProfileController as TeacherProfile;

use App\Http\Controllers\Student\StudentDashboardController as StudentDashboard;
use App\Http\Controllers\Student\StudentMarkController as StudentMark;
use App\Http\Controllers\Student\StudentProfileController as StudentProfile;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

// Dashboard redirect after login
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'admin') return redirect()->route('admin.dashboard');
    if ($user->role === 'teacher') return redirect()->route('teacher.dashboard');
    if ($user->role === 'student') return redirect()->route('student.dashboard');
    return redirect('/');
})->middleware('auth')->name('dashboard');

// Admin routes (only admin can access)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard'); // ✅
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('enrollments', EnrollmentController::class);
});

// ── Teacher routes ────────────────────────────────────────────
Route::middleware(['auth', 'teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboard::class, 'index'])->name('dashboard');
 
    // Marks
    Route::get('/marks',                  [TeacherMark::class, 'index'])->name('marks.index');
    Route::get('/marks/{enrollment}/edit',[TeacherMark::class, 'edit'])->name('marks.edit');
    Route::put('/marks/{enrollment}',     [TeacherMark::class, 'update'])->name('marks.update');
 
    // Profile 
    Route::get('/profile',                    [TeacherProfile::class, 'edit'])->name('profile.edit');
    Route::put('/profile/contact',            [TeacherProfile::class, 'updateContact'])->name('profile.updateContact');
    Route::put('/profile/password',           [TeacherProfile::class, 'updatePassword'])->name('profile.updatePassword');
});
 
// ── Student routes ────────────────────────────────────────────
Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('dashboard');
    Route::get('/marks',     [StudentMark::class, 'index'])->name('marks');
 
    // Profile 
    Route::get('/profile',           [StudentProfile::class, 'edit'])->name('profile.edit');
    Route::put('/profile/contact',   [StudentProfile::class, 'updateContact'])->name('profile.updateContact');
    Route::put('/profile/password',  [StudentProfile::class, 'updatePassword'])->name('profile.updatePassword');
});
 
require __DIR__.'/auth.php';