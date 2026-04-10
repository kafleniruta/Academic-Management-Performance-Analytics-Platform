<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageMarks();
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'marks' => 'required|numeric|min:0|max:100',
            'exam_type' => 'required|string|in:midterm,final,assignment,quiz,project',
            'remarks' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.exists' => 'Selected student does not exist.',
            'course_id.exists' => 'Selected course does not exist.',
            'marks.min' => 'Marks cannot be less than 0.',
            'marks.max' => 'Marks cannot exceed 100.',
            'exam_type.in' => 'Exam type must be one of: midterm, final, assignment, quiz, project.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = $this->user();
            $course = \App\Models\Course::find($this->course_id);
            
            if ($user->isTeacher() && $course && $course->teacher_id !== $user->id) {
                $validator->errors()->add('course_id', 'You can only add marks for your own courses.');
            }

            $existingMark = \App\Models\Mark::where('student_id', $this->student_id)
                ->where('course_id', $this->course_id)
                ->where('exam_type', $this->exam_type)
                ->first();

            if ($existingMark) {
                $validator->errors()->add('marks', 'A mark already exists for this student, course, and exam type.');
            }
        });
    }
}
