<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Mark;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample users for each role
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@academic.com',
            'password' => Hash::make('password'),
            'role_id' => 1, // Admin
            'phone' => '123-456-7890',
            'address' => '123 Admin St'
        ]);

        $teacher = User::create([
            'name' => 'John Teacher',
            'email' => 'teacher@academic.com',
            'password' => Hash::make('password'),
            'role_id' => 2, // Teacher
            'phone' => '123-456-7891',
            'address' => '456 Teacher Ave'
        ]);

        $studentUser = User::create([
            'name' => 'Jane Student',
            'email' => 'student@academic.com',
            'password' => Hash::make('password'),
            'role_id' => 3, // Student
            'phone' => '123-456-7892',
            'address' => '789 Student Rd'
        ]);

        // Create student record
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STU001',
            'enrollment_year' => 2024
        ]);

        // Create sample courses
        $course1 = Course::create([
            'name' => 'Introduction to Computer Science',
            'code' => 'CS101',
            'credit_hours' => 3,
            'description' => 'Basic computer science concepts',
            'teacher_id' => $teacher->id
        ]);

        $course2 = Course::create([
            'name' => 'Mathematics Fundamentals',
            'code' => 'MATH101',
            'credit_hours' => 4,
            'description' => 'Basic mathematics',
            'teacher_id' => $teacher->id
        ]);

        // Enroll student in courses
        Enrollment::create([
            'student_id' => $student->id,
            'course_id' => $course1->id,
            'status' => 'active'
        ]);

        Enrollment::create([
            'student_id' => $student->id,
            'course_id' => $course2->id,
            'status' => 'active'
        ]);

        // Create sample marks
        Mark::create([
            'student_id' => $student->id,
            'course_id' => $course1->id,
            'marks' => 85.50,
            'exam_type' => 'midterm',
            'remarks' => 'Good performance'
        ]);

        Mark::create([
            'student_id' => $student->id,
            'course_id' => $course1->id,
            'marks' => 92.00,
            'exam_type' => 'final',
            'remarks' => 'Excellent work'
        ]);

        Mark::create([
            'student_id' => $student->id,
            'course_id' => $course2->id,
            'marks' => 78.25,
            'exam_type' => 'midterm',
            'remarks' => 'Needs improvement'
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@academic.com / password');
        $this->command->info('Teacher: teacher@academic.com / password');
        $this->command->info('Student: student@academic.com / password');
    }
}
