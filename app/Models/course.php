<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'hours', 'material','time', 'chose']; // إضافة المزيد حسب الحاجة

    // علاقة المقرر مع الطلاب (Many-to-Many)
    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_students', 'course_id', 'student_id')
            ->withPivot('grade', 'firstOrSecond','department_id');
    } 


}
