<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prof extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'degree', 'specialization', 'department_id']; // إضافة المزيد حسب الحاجة
   
   
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
 


}
