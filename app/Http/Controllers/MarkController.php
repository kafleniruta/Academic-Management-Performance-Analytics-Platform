<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MarkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:admin,teacher')->except(['index', 'show', 'studentMarks']);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        
        $query = Mark::with(['student.user', 'course']);

        if ($user->isTeacher()) {
            $query->whereHas('course', function ($q) use ($user) {
                $q->where('teacher_id', $user->id);
            });
        }

        if ($user->isStudent()) {
            $query->whereHas('student', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->exam_type) {
            $query->where('exam_type', $request->exam_type);
        }

        if ($request->grade) {
            $query->where('grade', $request->grade);
        }

        if ($request->min_marks) {
            $query->where('marks', '>=', $request->min_marks);
        }

        if ($request->max_marks) {
            $query->where('marks', '<=', $request->max_marks);
        }

        $marks = $query->paginate($request->per_page ?? 15);

        return response()->json($marks);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'marks' => 'required|numeric|min:0|max:100',
            'exam_type' => 'required|string|in:midterm,final,assignment,quiz,project',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        $course = Course::findOrFail($request->course_id);

        if ($user->isTeacher() && $course->teacher_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized: You can only add marks for your own courses'], 403);
        }

        $existingMark = Mark::where('student_id', $request->student_id)
            ->where('course_id', $request->course_id)
            ->where('exam_type', $request->exam_type)
            ->first();

        if ($existingMark) {
            return response()->json(['message' => 'Mark already exists for this student, course, and exam type'], 422);
        }

        $mark = Mark::create($request->all());

        return response()->json($mark->load(['student.user', 'course']), 201);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        
        $mark = Mark::with(['student.user', 'course'])->findOrFail($id);

        if ($user->isTeacher() && $mark->course->teacher_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($user->isStudent() && $mark->student->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($mark);
    }

    public function update(Request $request, $id)
    {
        $mark = Mark::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'marks' => 'sometimes|required|numeric|min:0|max:100',
            'exam_type' => 'sometimes|required|string|in:midterm,final,assignment,quiz,project',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();

        if ($user->isTeacher() && $mark->course->teacher_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $mark->update($request->all());

        return response()->json($mark->fresh(['student.user', 'course']));
    }

    public function destroy($id)
    {
        $mark = Mark::findOrFail($id);
        $user = request()->user();

        if ($user->isTeacher() && $mark->course->teacher_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $mark->delete();

        return response()->json(['message' => 'Mark deleted successfully']);
    }

    public function studentMarks(Request $request, $studentId)
    {
        $user = $request->user();
        
        if ($user->isStudent() && $user->student?->id != $studentId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $student = Student::with(['user'])->findOrFail($studentId);

        $query = $student->marks()->with('course');

        if ($user->isTeacher()) {
            $query->whereHas('course', function ($q) use ($user) {
                $q->where('teacher_id', $user->id);
            });
        }

        if ($request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->exam_type) {
            $query->where('exam_type', $request->exam_type);
        }

        $marks = $query->paginate($request->per_page ?? 15);

        return response()->json($marks);
    }

    public function courseMarks(Request $request, $courseId)
    {
        $user = $request->user();
        $course = Course::findOrFail($courseId);

        if ($user->isTeacher() && $course->teacher_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $query = $course->marks()->with('student.user');

        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->exam_type) {
            $query->where('exam_type', $request->exam_type);
        }

        $marks = $query->paginate($request->per_page ?? 15);

        return response()->json($marks);
    }

    public function bulkStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'marks' => 'required|array|min:1',
            'marks.*.student_id' => 'required|exists:students,id',
            'marks.*.course_id' => 'required|exists:courses,id',
            'marks.*.marks' => 'required|numeric|min:0|max:100',
            'marks.*.exam_type' => 'required|string|in:midterm,final,assignment,quiz,project',
            'marks.*.remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        $createdMarks = [];

        foreach ($request->marks as $markData) {
            $course = Course::findOrFail($markData['course_id']);

            if ($user->isTeacher() && $course->teacher_id !== $user->id) {
                continue;
            }

            $existingMark = Mark::where('student_id', $markData['student_id'])
                ->where('course_id', $markData['course_id'])
                ->where('exam_type', $markData['exam_type'])
                ->first();

            if (!$existingMark) {
                $mark = Mark::create($markData);
                $createdMarks[] = $mark->load(['student.user', 'course']);
            }
        }

        return response()->json($createdMarks, 201);
    }

    public function getStatistics(Request $request)
    {
        $user = $request->user();
        
        $query = Mark::query();

        if ($user->isTeacher()) {
            $query->whereHas('course', function ($q) use ($user) {
                $q->where('teacher_id', $user->id);
            });
        }

        if ($request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->exam_type) {
            $query->where('exam_type', $request->exam_type);
        }

        $stats = [
            'total_marks' => $query->count(),
            'average_marks' => round($query->avg('marks'), 2),
            'highest_marks' => $query->max('marks'),
            'lowest_marks' => $query->min('marks'),
            'passing_students' => $query->where('marks', '>=', 50)->count(),
            'failing_students' => $query->where('marks', '<', 50)->count(),
            'grade_distribution' => $query->selectRaw('grade, COUNT(*) as count')
                ->groupBy('grade')
                ->orderBy('grade')
                ->get()
        ];

        return response()->json($stats);
    }
}
