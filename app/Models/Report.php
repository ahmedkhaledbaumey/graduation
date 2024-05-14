<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'type', 'date', 'prof_id', 'student_id' ,'head_id']; // إضافة المزيد حسب الحاجة

    // علاقة التقرير مع الأستاذ (Many-to-One)
    public function professor()
    {
        return $this->belongsTo(Prof::class, 'prof_id');
    }

    // علاقة التقرير مع الطالب (Many-to-One)
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
   

}
