<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:admin,teacher')->except(['index', 'show', 'myProfile', 'myCourses', 'myMarks']);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        
        $query = Student::with(['user', 'enrollments.course', 'marks.course']);

        if ($user->isStudent()) {
            $query->where('user_id', $user->id);
        }

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

        return response()->json($students);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'student_id' => 'required|string|unique:students',
            'enrollment_year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

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
            'student_id' => $request->student_id,
            'enrollment_year' => $request->enrollment_year,
        ]);

        return response()->json($student->load('user'), 201);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        
        $student = Student::with(['user', 'enrollments.course', 'marks.course'])
            ->findOrFail($id);

        if ($user->isStudent() && $student->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $student->user_id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'student_id' => 'sometimes|required|string|unique:students,student_id,' . $id,
            'enrollment_year' => 'sometimes|required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userData = $request->only('name', 'email', 'phone', 'address');
        $studentData = $request->only('student_id', 'enrollment_year');

        if (!empty($userData)) {
            $student->user->update($userData);
        }

        if (!empty($studentData)) {
            $student->update($studentData);
        }

        return response()->json($student->fresh('user'));
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        
        $student->user->delete();
        $student->delete();

        return response()->json(['message' => 'Student deleted successfully']);
    }

    public function myProfile(Request $request)
    {
        $student = $request->user()->student;
        
        if (!$student) {
            return response()->json(['message' => 'Student profile not found'], 404);
        }

        return response()->json($student->load('user'));
    }

    public function myCourses(Request $request)
    {
        $student = $request->user()->student;
        
        if (!$student) {
            return response()->json(['message' => 'Student profile not found'], 404);
        }

        $courses = $student->courses()
            ->withPivot('status', 'enrolled_at')
            ->with('teacher')
            ->paginate($request->per_page ?? 15);

        return response()->json($courses);
    }

    public function myMarks(Request $request)
    {
        $student = $request->user()->student;
        
        if (!$student) {
            return response()->json(['message' => 'Student profile not found'], 404);
        }

        $marks = $student->marks()
            ->with('course')
            ->paginate($request->per_page ?? 15);

        return response()->json($marks);
    }

    public function enrollInCourse(Request $request, $studentId, $courseId)
    {
        $student = Student::findOrFail($studentId);

        $existingEnrollment = $student->enrollments()
            ->where('course_id', $courseId)
            ->first();

        if ($existingEnrollment) {
            return response()->json(['message' => 'Student already enrolled in this course'], 422);
        }

        $enrollment = $student->enrollments()->create([
            'course_id' => $courseId,
            'status' => 'active',
        ]);

        return response()->json($enrollment->load('course'), 201);
    }

    public function dropCourse(Request $request, $studentId, $courseId)
    {
        $enrollment = $student->enrollments()
            ->where('course_id', $courseId)
            ->firstOrFail();

        $enrollment->markAsDropped();

        return response()->json(['message' => 'Course dropped successfully']);
    }
}
