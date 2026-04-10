<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'mark_id';
    protected $fillable = ['enrollment_id', 'exam_type', 'marks_obtained', 'grade', 'recorded_by'];
    
    // Auto-calculate grade when setting marks_obtained
    public function setMarksObtainedAttribute($value)
    {
        $this->attributes['marks_obtained'] = $value;
        $this->attributes['grade'] = $this->calculateGrade($value);
    }
    
    private function calculateGrade($marks)
    {
        if ($marks >= 90) return 'A';
        if ($marks >= 80) return 'A-';
        if ($marks >= 70) return 'B+';
        if ($marks >= 60) return 'B';
        if ($marks >= 50) return 'B-';
        if ($marks >= 40) return 'C';
        return 'F';
    }
    
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id');
    }
    
    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}