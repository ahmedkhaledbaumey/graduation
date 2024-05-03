<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentCourse extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // إضافة المزيد حسب الحاجة

    // علاقة مقرر القسم مع المقرر (Many-to-One)
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // علاقة مقرر القسم مع القسم (Many-to-One)
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
