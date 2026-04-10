<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'course_id';
    protected $fillable = ['course_name', 'course_code', 'credit_hours', 'teacher_id'];
    
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    
    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments', 'course_id', 'student_id');
    }
    
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id');
    }
}