<?php
// ============================================================
// FILE: app/Models/User.php
// ============================================================
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden   = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed'];

    public function isAdmin()   { return $this->role === 'admin'; }
    public function isTeacher() { return $this->role === 'teacher'; }
    public function isStudent() { return $this->role === 'student'; }

    // Teacher's courses
    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    // Student's enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    // Student's enrolled courses (through enrollments)
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'student_id', 'course_id');
    }

    // Student's submissions
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'student_id');
    }
}

