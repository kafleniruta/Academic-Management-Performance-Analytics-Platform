<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->decimal('marks', 5, 2);
            $table->string('grade');
            $table->string('exam_type')->default('final');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'course_id', 'exam_type']);

            // Add check constraint for marks range
            $table->check('marks >= 0 AND marks <= 100');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
