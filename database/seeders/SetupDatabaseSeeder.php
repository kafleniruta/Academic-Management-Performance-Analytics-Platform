<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SetupDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Drop all tables if they exist
        Schema::dropIfExists('marks');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('students');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');

        // Create roles table
        Schema::create('roles', function ($table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default roles
        DB::table('roles')->insert([
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Full system control'],
            ['name' => 'Teacher', 'slug' => 'teacher', 'description' => 'Manage courses and student performance'],
            ['name' => 'Student', 'slug' => 'student', 'description' => 'View personal academic data'],
        ]);

        // Create users table
        Schema::create('users', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });

        // Create students table
        Schema::create('students', function ($table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('student_id')->unique();
            $table->integer('enrollment_year');
            $table->timestamps();
        });

        // Create courses table
        Schema::create('courses', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('credit_hours');
            $table->text('description')->nullable();
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Create enrollments table
        Schema::create('enrollments', function ($table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['active', 'completed', 'dropped'])->default('active');
            $table->timestamp('enrolled_at')->useCurrent();
            $table->timestamps();
            $table->unique(['student_id', 'course_id']);
        });

        // Create marks table
        Schema::create('marks', function ($table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->decimal('marks', 5, 2);
            $table->string('grade');
            $table->string('exam_type')->default('final');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->unique(['student_id', 'course_id', 'exam_type']);
            // Marks validation will be handled at application level
        });

        $this->command->info('Database tables created successfully!');
    }
}
