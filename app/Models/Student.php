<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_id',
        'enrollment_year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
            ->withPivot('status', 'enrolled_at')
            ->withTimestamps();
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function getFullNameAttribute()
    {
        return $this->user->name;
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    public function getPhoneAttribute()
    {
        return $this->user->phone;
    }

    public function getAddressAttribute()
    {
        return $this->user->address;
    }

    public function getAverageMarksAttribute()
    {
        return $this->marks()->avg('marks');
    }

    public function getGPAAttribute()
    {
        $average = $this->average_marks;
        
        if ($average >= 90) return 4.0;
        if ($average >= 85) return 3.7;
        if ($average >= 80) return 3.3;
        if ($average >= 75) return 3.0;
        if ($average >= 70) return 2.7;
        if ($average >= 65) return 2.3;
        if ($average >= 60) return 2.0;
        if ($average >= 55) return 1.7;
        if ($average >= 50) return 1.3;
        
        return 0.0;
    }
}
