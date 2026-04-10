<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Enrollment;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacherId = Auth::user()->teacher->user_id ?? null;
        
        $myCourses = Course::where('teacher_id', $teacherId)->get();
        $courseIds = $myCourses->pluck('course_id');
        
        $data = [
            'myCourses' => $myCourses,
            'totalCourses' => $myCourses->count(),
            'totalStudents' => Enrollment::whereIn('course_id', $courseIds)->count(),
            'recentEnrollments' => Enrollment::with(['student.user', 'course'])
                ->whereIn('course_id', $courseIds)
                ->latest()
                ->take(5)
                ->get(),
        ];
        
        return view('teacher.dashboard', $data);
    }
}