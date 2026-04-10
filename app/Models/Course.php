<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'credit_hours',
        'description',
        'teacher_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
            ->withPivot('status', 'enrolled_at')
            ->withTimestamps();
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function getEnrolledStudentsCountAttribute()
    {
        return $this->enrollments()->where('status', 'active')->count();
    }

    public function getAverageMarksAttribute()
    {
        return $this->marks()->avg('marks');
    }

    public function scopeActive($query)
    {
        return $query->whereHas('enrollments', function ($q) {
            $q->where('status', 'active');
        });
    }

    public function scopeByTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }
}
