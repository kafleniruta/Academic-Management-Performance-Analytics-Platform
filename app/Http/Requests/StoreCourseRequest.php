<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageCourses();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:courses',
            'credit_hours' => 'required|integer|min:1|max:10',
            'description' => 'nullable|string',
            'teacher_id' => 'nullable|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'This course code is already in use.',
            'credit_hours.min' => 'Credit hours must be at least 1.',
            'credit_hours.max' => 'Credit hours cannot exceed 10.',
            'teacher_id.exists' => 'Selected teacher does not exist.',
        ];
    }
}
