<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'date', 'supervisor', 'idea', 'student_id']; // إضافة المزيد حسب الحاجة

    // علاقة الندوة مع الطالب (Many-to-One)
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
