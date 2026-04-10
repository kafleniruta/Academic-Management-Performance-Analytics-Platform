<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use App\Models\Mark;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $studentId = Auth::user()->student->user_id ?? null;
        
        $enrollments = Enrollment::with('course')
            ->where('student_id', $studentId)
            ->get();
        
        $marks = Mark::with(['enrollment.course'])
            ->whereHas('enrollment', function($q) use ($studentId) {
                $q->where('student_id', $studentId);
            })
            ->get();
        
        return view('student.dashboard', compact('enrollments', 'marks'));
    }
}