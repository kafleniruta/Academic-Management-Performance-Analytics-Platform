<?php
 
namespace App\Http\Controllers\Student;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use App\Models\Mark;
 
class StudentMarkController extends Controller
{
    public function index()
    {
        $studentId = Auth::user()->student->user_id ?? null;
 
        // Get all enrollments for this student, with course and mark data
        $enrollments = Enrollment::with(['course', 'mark'])
            ->where('student_id', $studentId)
            ->get();
 
        // Summary stats
        $marks        = $enrollments->pluck('mark')->filter();
        $totalCourses = $enrollments->count();
        $avgMark      = $marks->avg('marks_obtained') ? round($marks->avg('marks_obtained'), 2) : null;
        $passCount    = $marks->where('marks_obtained', '>=', 40)->count();
        $failCount    = $marks->where('marks_obtained', '<', 40)->count();
 
        return view('student.marks', compact(
            'enrollments',
            'totalCourses',
            'avgMark',
            'passCount',
            'failCount'
        ));
    }
}
 