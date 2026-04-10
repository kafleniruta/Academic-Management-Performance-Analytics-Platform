<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mark;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        // 1️⃣ Average marks per course
        $avgMarks = Mark::join('enrollments', 'marks.enrollment_id', '=', 'enrollments.enrollment_id')
            ->join('courses', 'enrollments.course_id', '=', 'courses.course_id')
            ->select('courses.course_name', DB::raw('AVG(marks.marks_obtained) as average'))
            ->groupBy('courses.course_name')
            ->get();

        // 2️⃣ Pass / Fail count
        $pass = Mark::where('marks_obtained', '>=', 40)->count();
        $fail = Mark::where('marks_obtained', '<', 40)->count();

        // 3️⃣ Top 5 students
        $topStudents = Mark::join('enrollments', 'marks.enrollment_id', '=', 'enrollments.enrollment_id')
            ->join('students', 'enrollments.student_id', '=', 'students.user_id')
            ->select('students.student_name', DB::raw('AVG(marks.marks_obtained) as avg_marks'))
            ->groupBy('students.student_name')
            ->orderByDesc('avg_marks')
            ->take(5)
            ->get();

        // 4️⃣ Total students
        $totalStudents = Student::count();

        // 5️⃣ Pass / fail percentage (optional for charts)
        $totalMarks = $pass + $fail;
        $passPercent = $totalMarks > 0 ? round(($pass / $totalMarks) * 100, 2) : 0;
        $failPercent = $totalMarks > 0 ? round(($fail / $totalMarks) * 100, 2) : 0;

        return view('admin.dashboard', compact(
            'avgMarks',
            'pass',
            'fail',
            'topStudents',
            'passPercent',
            'failPercent',
            'totalStudents'
        ));
    }
}