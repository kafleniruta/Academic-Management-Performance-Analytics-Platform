<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $query = Mark::with(['student.user', 'course']);

        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->exam_type) {
            $query->where('exam_type', $request->exam_type);
        }

        $marks = $query->paginate($request->per_page ?? 15);
        $students = Student::with('user')->get();
        $courses = Course::all();

        // Calculate statistics
        $stats = [
            'average_marks' => Mark::avg('marks'),
            'passing_students' => Mark::where('marks', '>=', 50)->distinct('student_id')->count(),
            'failing_students' => Mark::where('marks', '<', 50)->distinct('student_id')->count(),
            'highest_marks' => Mark::max('marks'),
        ];

        return view('marks.index', compact('marks', 'students', 'courses', 'stats'));
    }

    public function create()
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $students = Student::with('user')->get();
        $courses = Course::all();

        return view('marks.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'marks' => 'required|numeric|min:0|max:100',
            'exam_type' => 'required|string|in:midterm,final,assignment,quiz,project',
            'remarks' => 'nullable|string',
        ]);

        // Check if mark already exists for this student, course, and exam type
        $existingMark = Mark::where([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'exam_type' => $request->exam_type,
        ])->first();

        if ($existingMark) {
            return redirect()->back()->with('error', 'Mark already exists for this student, course, and exam type.');
        }

        // Calculate grade based on marks
        $grade = $this->calculateGrade($request->marks);

        Mark::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'marks' => $request->marks,
            'grade' => $grade,
            'exam_type' => $request->exam_type,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('marks.index')->with('success', 'Mark created successfully.');
    }

    public function show($id)
    {
        $user = Auth::user();
        
        $mark = Mark::with(['student.user', 'course'])->findOrFail($id);

        // Students can only view their own marks
        if ($user->isStudent()) {
            $student = $user->student;
            if (!$student || $mark->student_id !== $student->id) {
                abort(403);
            }
        }

        return view('marks.show', compact('mark'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $mark = Mark::findOrFail($id);
        $students = Student::with('user')->get();
        $courses = Course::all();

        return view('marks.edit', compact('mark', 'students', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $mark = Mark::findOrFail($id);

        $request->validate([
            'student_id' => 'sometimes|required|exists:students,id',
            'course_id' => 'sometimes|required|exists:courses,id',
            'marks' => 'sometimes|required|numeric|min:0|max:100',
            'exam_type' => 'sometimes|required|string|in:midterm,final,assignment,quiz,project',
            'remarks' => 'nullable|string',
        ]);

        $data = $request->all();

        // Recalculate grade if marks are updated
        if ($request->has('marks')) {
            $data['grade'] = $this->calculateGrade($request->marks);
        }

        $mark->update($data);

        return redirect()->route('marks.index')->with('success', 'Mark updated successfully.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $mark = Mark::findOrFail($id);
        $mark->delete();

        return redirect()->route('marks.index')->with('success', 'Mark deleted successfully.');
    }

    public function statistics()
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $stats = [
            'total_marks' => Mark::count(),
            'average_marks' => Mark::avg('marks'),
            'highest_marks' => Mark::max('marks'),
            'lowest_marks' => Mark::min('marks'),
            'passing_students' => Mark::where('marks', '>=', 50)->distinct('student_id')->count(),
            'failing_students' => Mark::where('marks', '<', 50)->distinct('student_id')->count(),
        ];

        // Grade distribution
        $gradeDistribution = [
            'A+' => Mark::where('grade', 'A+')->count(),
            'A' => Mark::where('grade', 'A')->count(),
            'B+' => Mark::where('grade', 'B+')->count(),
            'B' => Mark::where('grade', 'B')->count(),
            'C+' => Mark::where('grade', 'C+')->count(),
            'C' => Mark::where('grade', 'C')->count(),
            'D' => Mark::where('grade', 'D')->count(),
            'F' => Mark::where('grade', 'F')->count(),
        ];

        return view('marks.statistics', compact('stats', 'gradeDistribution'));
    }

    private function calculateGrade($marks)
    {
        if ($marks >= 90) return 'A+';
        if ($marks >= 85) return 'A';
        if ($marks >= 80) return 'B+';
        if ($marks >= 75) return 'B';
        if ($marks >= 70) return 'C+';
        if ($marks >= 65) return 'C';
        if ($marks >= 50) return 'D';
        return 'F';
    }
}
