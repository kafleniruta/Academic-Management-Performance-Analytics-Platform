<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:admin,teacher')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        
        $query = Course::with(['teacher', 'students', 'marks']);

        if ($user->isTeacher()) {
            $query->where('teacher_id', $user->id);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        if ($request->teacher_id) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->credit_hours) {
            $query->where('credit_hours', $request->credit_hours);
        }

        $courses = $query->paginate($request->per_page ?? 15);

        return response()->json($courses);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:courses',
            'credit_hours' => 'required|integer|min:1|max:10',
            'description' => 'nullable|string',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();

        if ($user->isTeacher() && $request->teacher_id && $request->teacher_id != $user->id) {
            return response()->json(['message' => 'Teachers can only assign themselves to courses'], 403);
        }

        if ($user->isTeacher() && !$request->teacher_id) {
            $request->merge(['teacher_id' => $user->id]);
        }

        $course = Course::create($request->all());

        return response()->json($course->load('teacher'), 201);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        
        $course = Course::with(['teacher', 'students.user', 'marks.student'])
            ->findOrFail($id);

        if ($user->isTeacher() && $course->teacher_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($course);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|required|string|unique:courses,code,' . $id,
            'credit_hours' => 'sometimes|required|integer|min:1|max:10',
            'description' => 'nullable|string',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();

        if ($user->isTeacher() && $request->teacher_id && $request->teacher_id != $user->id) {
            return response()->json(['message' => 'Teachers can only assign themselves to courses'], 403);
        }

        if ($user->isTeacher() && $course->teacher_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $course->update($request->all());

        return response()->json($course->fresh('teacher'));
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        $user = request()->user();

        if ($user->isTeacher() && $course->teacher_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $course->delete();

        return response()->json(['message' => 'Course deleted successfully']);
    }

    public function enrollStudent(Request $request, $courseId, $studentId)
    {
        $course = Course::findOrFail($courseId);
        $user = $request->user();

        if ($user->isTeacher() && $course->teacher_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $existingEnrollment = $course->enrollments()
            ->where('student_id', $studentId)
            ->first();

        if ($existingEnrollment) {
            return response()->json(['message' => 'Student already enrolled in this course'], 422);
        }

        $enrollment = $course->enrollments()->create([
            'student_id' => $studentId,
            'status' => 'active',
        ]);

        return response()->json($enrollment->load('student.user'), 201);
    }

    public function removeStudent(Request $request, $courseId, $studentId)
    {
        $course = Course::findOrFail($courseId);
        $user = $request->user();

        if ($user->isTeacher() && $course->teacher_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $enrollment = $course->enrollments()
            ->where('student_id', $studentId)
            ->firstOrFail();

        $enrollment->markAsDropped();

        return response()->json(['message' => 'Student removed from course successfully']);
    }

    public function getEnrolledStudents(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);
        $user = $request->user();

        if ($user->isTeacher() && $course->teacher_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $students = $course->students()
            ->withPivot('status', 'enrolled_at')
            ->with('user')
            ->paginate($request->per_page ?? 15);

        return response()->json($students);
    }

    public function getAvailableTeachers()
    {
        $teachers = User::whereHas('role', function ($query) {
            $query->where('slug', 'teacher');
        })->get();

        return response()->json($teachers);
    }
}
