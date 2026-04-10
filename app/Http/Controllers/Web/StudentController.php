<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
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

        $query = Student::with(['user', 'enrollments.course', 'marks.course']);

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->enrollment_year) {
            $query->where('enrollment_year', $request->enrollment_year);
        }

        $students = $query->paginate($request->per_page ?? 15);

        return view('students.index', compact('students'));
    }

    public function create()
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        return view('students.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'roll_number' => 'required|string|unique:students',
            'enrollment_year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $studentRole = Role::where('slug', 'student')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role_id' => $studentRole->id,
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'roll_number' => $request->roll_number,
            'enrollment_year' => $request->enrollment_year,
        ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show($id)
    {
        $user = Auth::user();
        
        $student = Student::with(['user', 'enrollments.course', 'marks.course'])
            ->findOrFail($id);

        if ($user->isStudent() && $student->user_id !== $user->id) {
            abort(403);
        }

        return view('students.show', compact('student'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $student = Student::with('user')->findOrFail($id);

        return view('students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $student = Student::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $student->user_id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'roll_number' => 'sometimes|required|string|unique:students,roll_number,' . $id,
            'enrollment_year' => 'sometimes|required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $userData = $request->only('name', 'email', 'phone', 'address');
        $studentData = $request->only('roll_number', 'enrollment_year');

        if (!empty($userData)) {
            $student->user->update($userData);
        }

        if (!empty($studentData)) {
            $student->update($studentData);
        }

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $student = Student::findOrFail($id);
        
        $student->user->delete();
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function myCourses()
    {
        $user = Auth::user();
        
        if (!$user->isStudent()) {
            abort(403);
        }

        $student = $user->student;
        
        if (!$student) {
            return redirect()->route('dashboard')->with('error', 'Student profile not found.');
        }

        $courses = $student->courses()
            ->withPivot('status', 'enrolled_at')
            ->with('teacher')
            ->paginate(15);

        return view('students.mycourses', compact('courses'));
    }

    public function myMarks()
    {
        $user = Auth::user();
        
        if (!$user->isStudent()) {
            abort(403);
        }

        $student = $user->student;
        
        if (!$student) {
            return redirect()->route('dashboard')->with('error', 'Student profile not found.');
        }

        $marks = $student->marks()
            ->with('course')
            ->paginate(15);

        return view('students.mymarks', compact('marks'));
    }
}
