<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('teacher')->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.courses.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|unique:courses,course_code',
            'credit_hours' => 'required|integer|min:1|max:6',
            'teacher_id' => 'nullable|exists:teachers,user_id',
        ]);

        Course::create($request->all());

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully!');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $teachers = Teacher::with('user')->get();
        return view('admin.courses.edit', compact('course', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|unique:courses,course_code,' . $id . ',course_id',
            'credit_hours' => 'required|integer|min:1|max:6',
            'teacher_id' => 'nullable|exists:teachers,user_id',
        ]);

        $course->update($request->all());

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully!');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully!');
    }
}