<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MarkController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user()->load('role');
});

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::put('profile', [AuthController::class, 'updateProfile']);
    });
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index']);
        Route::post('/', [StudentController::class, 'store'])->middleware('role:admin,teacher');
        Route::get('{id}', [StudentController::class, 'show']);
        Route::put('{id}', [StudentController::class, 'update'])->middleware('role:admin,teacher');
        Route::delete('{id}', [StudentController::class, 'destroy'])->middleware('role:admin,teacher');
        
        Route::get('my/profile', [StudentController::class, 'myProfile']);
        Route::get('my/courses', [StudentController::class, 'myCourses']);
        Route::get('my/marks', [StudentController::class, 'myMarks']);
        
        Route::post('{studentId}/enroll/{courseId}', [StudentController::class, 'enrollInCourse'])->middleware('role:admin,teacher');
        Route::delete('{studentId}/drop/{courseId}', [StudentController::class, 'dropCourse'])->middleware('role:admin,teacher');
    });

    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::post('/', [CourseController::class, 'store'])->middleware('role:admin,teacher');
        Route::get('{id}', [CourseController::class, 'show']);
        Route::put('{id}', [CourseController::class, 'update'])->middleware('role:admin,teacher');
        Route::delete('{id}', [CourseController::class, 'destroy'])->middleware('role:admin,teacher');
        
        Route::get('available-teachers', [CourseController::class, 'getAvailableTeachers']);
        
        Route::post('{courseId}/enroll/{studentId}', [CourseController::class, 'enrollStudent'])->middleware('role:admin,teacher');
        Route::delete('{courseId}/remove/{studentId}', [CourseController::class, 'removeStudent'])->middleware('role:admin,teacher');
        Route::get('{courseId}/students', [CourseController::class, 'getEnrolledStudents'])->middleware('role:admin,teacher');
    });

    Route::prefix('marks')->group(function () {
        Route::get('/', [MarkController::class, 'index']);
        Route::post('/', [MarkController::class, 'store'])->middleware('role:admin,teacher');
        Route::post('bulk', [MarkController::class, 'bulkStore'])->middleware('role:admin,teacher');
        Route::get('statistics', [MarkController::class, 'getStatistics']);
        
        Route::get('{id}', [MarkController::class, 'show']);
        Route::put('{id}', [MarkController::class, 'update'])->middleware('role:admin,teacher');
        Route::delete('{id}', [MarkController::class, 'destroy'])->middleware('role:admin,teacher');
        
        Route::get('student/{studentId}', [MarkController::class, 'studentMarks']);
        Route::get('course/{courseId}', [MarkController::class, 'courseMarks'])->middleware('role:admin,teacher');
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('stats', function (Request $request) {
            $user = $request->user();
            
            if ($user->isAdmin()) {
                return response()->json([
                    'total_students' => \App\Models\Student::count(),
                    'total_courses' => \App\Models\Course::count(),
                    'total_teachers' => \App\Models\User::whereHas('role', function($q) {
                        $q->where('slug', 'teacher');
                    })->count(),
                    'total_marks' => \App\Models\Mark::count(),
                ]);
            }
            
            if ($user->isTeacher()) {
                return response()->json([
                    'my_courses' => $user->taughtCourses()->count(),
                    'my_students' => \App\Models\Enrollment::whereHas('course', function($q) use ($user) {
                        $q->where('teacher_id', $user->id);
                    })->count(),
                    'pending_marks' => \App\Models\Mark::whereHas('course', function($q) use ($user) {
                        $q->where('teacher_id', $user->id);
                    })->count(),
                ]);
            }
            
            if ($user->isStudent()) {
                $student = $user->student;
                return response()->json([
                    'enrolled_courses' => $student?->enrollments()->active()->count() ?? 0,
                    'completed_courses' => $student?->enrollments()->completed()->count() ?? 0,
                    'average_marks' => $student?->average_marks ?? 0,
                    'gpa' => $student?->gpa ?? 0,
                ]);
            }
        });
    });
});
