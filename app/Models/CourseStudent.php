<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    use HasFactory;

    protected $fillable = ['grade', 'firstOrSecond']; // إضافة المزيد حسب الحاجة

    // علاقة طالب المقرر مع الطالب (Many-to-One)
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // علاقة طالب المقرر مع المقرر (Many-to-One)
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
