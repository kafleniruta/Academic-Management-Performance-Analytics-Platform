<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function taughtCourses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function isAdmin()
    {
        return $this->role?->slug === 'admin';
    }

    public function isTeacher()
    {
        return $this->role?->slug === 'teacher';
    }

    public function isStudent()
    {
        return $this->role?->slug === 'student';
    }

    public function hasRole($role)
    {
        return $this->role?->slug === $role;
    }

    public function canAccessAdminPanel()
    {
        return $this->isAdmin() || $this->isTeacher();
    }

    public function canManageStudents()
    {
        return $this->isAdmin() || $this->isTeacher();
    }

    public function canManageCourses()
    {
        return $this->isAdmin() || $this->isTeacher();
    }

    public function canManageMarks()
    {
        return $this->isAdmin() || $this->isTeacher();
    }

    public function canViewOwnData()
    {
        return $this->isStudent();
    }
}
