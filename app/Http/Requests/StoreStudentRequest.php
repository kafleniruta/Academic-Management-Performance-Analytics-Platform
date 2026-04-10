<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageStudents();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'student_id' => 'required|string|unique:students',
            'enrollment_year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'This email is already registered.',
            'student_id.unique' => 'This student ID is already in use.',
            'enrollment_year.max' => 'Enrollment year cannot be in the future.',
            'password.min' => 'Password must be at least 8 characters.',
        ];
    }
}
