<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Mark;

class TeacherMarkController extends Controller
{
    /**
     * Show all courses taught by this teacher.
     */
    public function index()
    {
        $teacherId = Auth::user()->teacher->user_id ?? null;

        $courses = Course::where('teacher_id', $teacherId)
            ->withCount('enrollments')
            ->orderBy('course_name')
            ->get();

        return view('teacher.marks.index', compact('courses'));
    }

    /**
     * Show all enrolled students for a course with their current marks.
     */
    public function edit(Enrollment $enrollment)
    {
        $teacherId = Auth::user()->teacher->user_id ?? null;

        // Resolve the course from the enrollment
        $course = Course::where('course_id', $enrollment->course_id)
            ->where('teacher_id', $teacherId)
            ->firstOrFail();

        // Load all enrollments for this course with student + mark
        $enrollments = Enrollment::with(['student', 'mark'])
            ->where('course_id', $course->course_id)
            ->get();

        return view('teacher.marks.edit', compact('course', 'enrollments'));
    }

    /**
     * Create or update a mark for a specific enrollment.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $teacherId = Auth::user()->teacher->user_id ?? null;

        // Verify this teacher owns the course
        $course = Course::where('course_id', $enrollment->course_id)
            ->where('teacher_id', $teacherId)
            ->firstOrFail();

        $request->validate([
            'marks_obtained' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $marksObtained = $request->marks_obtained;
        $grade         = $this->calculateGrade($marksObtained);

        Mark::updateOrCreate(
            ['enrollment_id' => $enrollment->enrollment_id],
            [
                'marks_obtained' => $marksObtained,
                'grade'          => $grade,
                'recorded_by'    => Auth::id(),
            ]
        );

        return back()->with('success', "Marks saved for {$enrollment->student->student_name}.");
    }

    /**
     * Calculate letter grade from numeric marks.
     */
    private function calculateGrade(float $marks): string
    {
        return match (true) {
            $marks >= 90 => 'A',
            $marks >= 80 => 'A-',
            $marks >= 70 => 'B+',
            $marks >= 60 => 'B',
            $marks >= 50 => 'B-',
            $marks >= 40 => 'C',
            default      => 'F',
        };
    }
}