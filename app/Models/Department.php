<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'research_plan', 'head_id'];

    // علاقة القسم مع الطلاب (One-to-Many)
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // علاقة القسم مع الدورات (One-to-Many)
    public function departmentCourses()
    {
        return $this->hasMany(DepartmentCourse::class);
    }

    // علاقة القسم مع رئيس القسم (One-to-One)
    public function head()
    {
        return $this->hasOne(Head::class);
    }
}
