<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function isAdmin()
    {
        return $this->slug === 'admin';
    }

    public function isTeacher()
    {
        return $this->slug === 'teacher';
    }

    public function isStudent()
    {
        return $this->slug === 'student';
    }
}
