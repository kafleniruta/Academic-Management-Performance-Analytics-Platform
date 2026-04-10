<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $stats = [];

        if ($user->isAdmin()) {
            $stats = [
                'total_students' => \App\Models\Student::count(),
                'total_courses' => \App\Models\Course::count(),
                'total_teachers' => \App\Models\User::whereHas('role', function($q) {
                    $q->where('slug', 'teacher');
                })->count(),
                'total_marks' => \App\Models\Mark::count(),
            ];
        } elseif ($user->isTeacher()) {
            $stats = [
                'my_courses' => $user->taughtCourses()->count(),
                'my_students' => \App\Models\Enrollment::whereHas('course', function($q) use ($user) {
                    $q->where('teacher_id', $user->id);
                })->count(),
                'pending_marks' => \App\Models\Mark::whereHas('course', function($q) use ($user) {
                    $q->where('teacher_id', $user->id);
                })->count(),
            ];
        } elseif ($user->isStudent()) {
            $student = $user->student;
            $stats = [
                'enrolled_courses' => $student?->enrollments()->active()->count() ?? 0,
                'completed_courses' => $student?->enrollments()->completed()->count() ?? 0,
                'average_marks' => $student?->average_marks ?? 0,
                'gpa' => $student?->gpa ?? 0,
            ];
        }

        return view('dashboard', compact('stats'));
    }

    public function adminDashboard(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            abort(403);
        }

        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_students' => \App\Models\Student::count(),
            'total_courses' => \App\Models\Course::count(),
            'total_teachers' => \App\Models\User::whereHas('role', function($q) {
                $q->where('slug', 'teacher');
            })->count(),
            'total_admins' => \App\Models\User::whereHas('role', function($q) {
                $q->where('slug', 'admin');
            })->count(),
            'total_marks' => \App\Models\Mark::count(),
            'total_roles' => \App\Models\Role::count(),
            'active_enrollments' => \App\Models\Enrollment::where('status', 'active')->count(),
            'average_marks' => \App\Models\Mark::avg('marks'),
            'passing_students' => \App\Models\Mark::where('marks', '>=', 50)->distinct('student_id')->count(),
            'failing_students' => \App\Models\Mark::where('marks', '<', 50)->distinct('student_id')->count(),
        ];

        $recentUsers = \App\Models\User::with('role')->latest()->take(5)->get();
        $recentCourses = \App\Models\Course::with('teacher')->latest()->take(5)->get();
        $recentMarks = \App\Models\Mark::with(['student.user', 'course'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentCourses', 'recentMarks'));
    }
}
