<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['student.user', 'course'])->paginate(10);
        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $students = Student::with('user')->get();
        $courses = Course::all();
        return view('admin.enrollments.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,user_id',
            'course_id' => 'required|exists:courses,course_id',
            'enrollment_year' => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'semester' => 'required|in:Fall,Spring,Summer',
        ]);

        $exists = Enrollment::where('student_id', $request->student_id)
            ->where('course_id', $request->course_id)
            ->where('enrollment_year', $request->enrollment_year)
            ->where('semester', $request->semester)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Student is already enrolled in this course!');
        }

        Enrollment::create($request->all());

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Student enrolled successfully!');
    }

    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment removed successfully!');
    }
}