<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class ViceDean extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    // Constants defining type, degree, and level options
 

    protected $fillable = [ 
        'email' , 'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // علاقة الطالب مع القسم (Many-to-One)
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // علاقة الطالب مع الدورات (Many-to-Many)
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_students', 'student_id', 'course_id')
            ->withPivot('grade', 'firstOrSecond');
    }

    // علاقة الطالب مع التقارير (One-to-Many)
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // علاقة الطالب مع الندوات (One-to-Many)
    public function seminars()
    {
        return $this->hasMany(Seminar::class);
    }

    // علاقة الطالب مع الصور (One-to-One)
    public function studentPhotos()
    {
        return $this->hasOne(StudentPhotos::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
