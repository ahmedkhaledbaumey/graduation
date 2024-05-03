<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentProfessor extends Model
{
    use HasFactory;

    protected $fillable = ['prof_id', 'vice_dean_id']; // الحقول التي يمكن تعبئتها بشكل كتابي

    // علاقة مع جدول الأساتذة (Prof)
    public function professor()
    {
        return $this->belongsTo(Prof::class, 'prof_id');
    }

    // علاقة مع جدول نواب العميد (ViceDean)
    public function viceDean()
    {
        return $this->belongsTo(ViceDean::class, 'vice_dean_id');
    }
}
