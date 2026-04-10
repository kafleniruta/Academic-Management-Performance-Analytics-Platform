<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $primaryKey = 'enrollment_id';
    protected $table = 'enrollments';
    
    protected $fillable = [
        'student_id',
        'course_id',
        'enrollment_year',
        'semester',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function marks()
    {
        return $this->hasOne(Mark::class, 'enrollment_id');
    }
}