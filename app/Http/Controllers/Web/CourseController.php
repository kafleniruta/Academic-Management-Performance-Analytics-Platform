<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
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

        $query = Course::with('teacher');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        if ($request->teacher_id) {
            $query->where('teacher_id', $request->teacher_id);
        }

        $courses = $query->paginate($request->per_page ?? 15);
        $teachers = User::whereHas('role', function($q) {
            $q->where('slug', 'teacher');
        })->get();

        return view('courses.index', compact('courses', 'teachers'));
    }

    public function create()
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $teachers = User::whereHas('role', function($q) {
            $q->where('slug', 'teacher');
        })->get();

        return view('courses.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:courses',
            'credit_hours' => 'required|integer|min:1|max:10',
            'description' => 'nullable|string',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function show($id)
    {
        $user = Auth::user();
        
        $course = Course::with(['teacher', 'enrollments.student.user', 'marks.student.user'])->findOrFail($id);

        // Students can only view their enrolled courses
        if ($user->isStudent()) {
            $student = $user->student;
            if (!$student || !$course->students()->where('student_id', $student->id)->exists()) {
                abort(403);
            }
        }

        return view('courses.show', compact('course'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $course = Course::findOrFail($id);
        $teachers = User::whereHas('role', function($q) {
            $q->where('slug', 'teacher');
        })->get();

        return view('courses.edit', compact('course', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $course = Course::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|required|string|max:255|unique:courses,code,' . $id,
            'credit_hours' => 'sometimes|required|integer|min:1|max:10',
            'description' => 'nullable|string',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        $course->update($request->all());

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    public function getAvailableTeachers()
    {
        $teachers = User::whereHas('role', function($q) {
            $q->where('slug', 'teacher');
        })->get(['id', 'name']);

        return response()->json($teachers);
    }
}
