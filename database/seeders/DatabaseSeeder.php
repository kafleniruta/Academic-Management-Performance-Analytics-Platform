<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        \App\Models\User::create([
            'email' => 'admin@buddhatech.com',
            'password_hash' => Hash::make('admin123'),
            'role' => 'admin',
            'contact_number' => '1234567890'
        ]);
        
        // Create Student User
        $studentUser = \App\Models\User::create([
            'email' => 'student@buddhatech.com',
            'password_hash' => Hash::make('student123'),
            'role' => 'student',
            'contact_number' => '9876543210'
        ]);
        
        // Create Student Profile
        \App\Models\Student::create([
            'user_id' => $studentUser->user_id,
            'student_name' => 'John Doe',
            'address' => '123 Main St, City'
        ]);
        
        // Create Teacher User
        $teacherUser = \App\Models\User::create([
            'email' => 'teacher@buddhatech.com',
            'password_hash' => Hash::make('teacher123'),
            'role' => 'teacher',
            'contact_number' => '5555555555'
        ]);
        
        // Create Teacher Profile
        \App\Models\Teacher::create([
            'user_id' => $teacherUser->user_id,
            'contact_number' => '5555555555',
            'qualification' => 'PhD in Computer Science'
        ]);
        
        // Create Course
        \App\Models\Course::create([
            'course_name' => 'Database Systems',
            'course_code' => 'CS401',
            'credit_hours' => 3,
            'teacher_id' => $teacherUser->user_id
        ]);
    }
}