<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->foreignId('enrollment_id')->primary()->constrained('enrollments', 'enrollment_id')->onDelete('cascade');
            $table->decimal('marks_obtained', 5, 2)->nullable();
            $table->char('grade', 2)->nullable();
            $table->foreignId('recorded_by')->constrained('users', 'user_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};