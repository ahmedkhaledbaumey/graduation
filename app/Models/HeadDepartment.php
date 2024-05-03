<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadDepartment extends Model
{
    use HasFactory;

    protected $table = 'head_department';

    protected $fillable = [
        'head_id',
        'department_id',
    ];

    // علاقة رئيس القسم بالقسم (Many-to-One)
    public function head()
    {
        return $this->belongsTo(Head::class, 'head_id');
    }

    // علاقة القسم برئيسه (One-to-One inverse of head)
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
