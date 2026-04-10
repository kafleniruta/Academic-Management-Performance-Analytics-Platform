<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'marks',
        'grade',
        'exam_type',
        'remarks',
    ];

    protected $casts = [
        'marks' => 'decimal:2',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($mark) {
            $mark->grade = $mark->calculateGrade($mark->marks);
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function calculateGrade($marks)
    {
        if ($marks >= 90) return 'A+';
        if ($marks >= 85) return 'A';
        if ($marks >= 80) return 'A-';
        if ($marks >= 75) return 'B+';
        if ($marks >= 70) return 'B';
        if ($marks >= 65) return 'B-';
        if ($marks >= 60) return 'C+';
        if ($marks >= 55) return 'C';
        if ($marks >= 50) return 'C-';
        if ($marks >= 45) return 'D';
        
        return 'F';
    }

    public function getGradePointsAttribute()
    {
        $grade = $this->grade;
        
        return match($grade) {
            'A+' => 4.0,
            'A' => 4.0,
            'A-' => 3.7,
            'B+' => 3.3,
            'B' => 3.0,
            'B-' => 2.7,
            'C+' => 2.3,
            'C' => 2.0,
            'C-' => 1.7,
            'D' => 1.0,
            'F' => 0.0,
            default => 0.0,
        };
    }

    public function isPassing()
    {
        return $this->marks >= 50;
    }

    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeByCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }

    public function scopePassing($query)
    {
        return $query->where('marks', '>=', 50);
    }

    public function scopeFailing($query)
    {
        return $query->where('marks', '<', 50);
    }
}
