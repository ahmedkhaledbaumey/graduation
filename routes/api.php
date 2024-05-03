<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MastersController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CouresStudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'prefix' => 'auth/admin'
], function () {
    Route::post('/login', [StudentController::class, 'login']);
    Route::post('/register', [StudentController::class, 'register']);
    Route::post('/logout', [StudentController::class, 'logout']);
    Route::post('/refresh', [StudentController::class, 'refresh']);
    Route::get('/user-profile', [StudentController::class, 'userProfile']);    
    // Route::get('/upload_data', [StudentController::class, 'uploadData']); 
    
}); 

// Department routes
// Route::apiResource('departments', DepartmentController::class); 
Route::get('departments', [DepartmentController::class, 'index']);
Route::post('departments', [DepartmentController::class, 'store']);
Route::get('departments/{id}', [DepartmentController::class, 'show']);
Route::put('departments/{id}', [DepartmentController::class, 'update']);
Route::delete('departments/{id}', [DepartmentController::class, 'destroy']); 
Route::post('/courses/enroll', [CouresStudentController::class, 'enrollCourses']);
Route::get('/course-students', [CouresStudentController::class, 'index']); // عرض جميع سجلات المستخدمين في الكورس
Route::post('/course-students', [CouresStudentController::class, 'store']); // إنشاء سجل جديد لمستخدم في الكورس
Route::get('/course-students/{courseStudent}', [CouresStudentController::class, 'show']); // عرض تفاصيل سجل مستخدم معين في الكورس
Route::put('/course-students/{courseStudent}', [CouresStudentController::class, 'update']); // تحديث بيانات سجل مستخدم في الكورس
Route::delete('/course-students/{courseStudent}', [CouresStudentController::class, 'destroy']); // حذف سجل مستخدم من الكورس 


// Routes for CourseController
Route::get('/courses', [CourseController::class, 'index']); // عرض جميع المقررات
Route::post('/courses', [CourseController::class, 'store']); // إنشاء مقرر جديد
Route::get('/courses/{course}', [CourseController::class, 'show']); // عرض تفاصيل مقرر معين
Route::put('/courses/{course}', [CourseController::class, 'update']); // تحديث بيانات مقرر معين
Route::delete('/courses/{course}', [CourseController::class, 'destroy']); // حذف مقرر معين