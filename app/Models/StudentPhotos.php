<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPhotos extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'enrollment_papers', 'original_bachelors_degree', 'personalImage', 'four_years_grades',
        'master_degree',
        'BirthCertificate',
        'IDCardCopy',
        'RecruitmentPosition',
        'EmployerApproval',
        'superAccpet',
    ];
}
