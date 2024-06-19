<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HeadController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StripeController;

// Authentication Routes
Route::post('/auth/loginall/{guard}', [AdminController::class, 'loginall']);
Route::post('/auth/loginstudent', [AdminController::class, 'loginstudent']);
Route::post('/auth/login', [StudentController::class, 'login']);
Route::post('/adminlogin', [HeadController::class, 'adminlogin']);
Route::post('/headlogin', [HeadController::class, 'headlogin']);
Route::post('/auth/register', [StudentController::class, 'register']);
Route::post('/auth/user-profile/{guard_name}', [AdminController::class, 'userProfile']);
// Admin Authentication Routes
Route::post('/auth/login/{guard_name}', [AdminController::class, 'login']);
// Route::post('/auth/login/prof', [AdminController::class, 'loginprof']);
// Route::post('/auth/login/employee', [AdminController::class, 'loginemployee']);
// Route::post('/auth/login/vice', [AdminController::class, 'loginvice']);

// Protected Routes (require student authentication)
Route::middleware('auth:student')->group(function () {
    // Logout route
    Route::post('/auth/logout', [StudentController::class, 'logout']);
    // Refresh token route
    Route::post('/auth/refresh', [StudentController::class, 'refresh']);
    // User profile route
    Route::post('/auth/user-profile', [StudentController::class, 'userProfile']);
    // Enroll courses route
    Route::post('/courses/enroll', [StudentController::class, 'enrollCourses'])->middleware('auth:student');
    // Route::post('/courses/enrollCourseToDep', [StudentController::class, 'enrollCourseToDep']);
    // Show grade route
    Route::post('/showgrade', [StudentController::class, 'showgrade'])->middleware('auth:student');
    // Show courses route
    Route::post('/showcourses', [StudentController::class, 'showcourses'])->middleware('auth:student');
    Route::post('/showcoursesForDepartment', [StudentController::class, 'showcoursesForDepartment'])->middleware('auth:student');
    // Show reports route
    Route::post('/showreports', [StudentController::class, 'showreports'])->middleware('auth:head');
    // Show specific report for student route
    Route::post('/showreportsstudent', [StudentController::class, 'showreportsstudent'])->middleware('auth:student');
    // Show specific report for professor route
    Route::post('/showreportsprof', [StudentController::class, 'showreportsprof'])->middleware('auth:prof');
    // Show specific report for department head route
    Route::post('/showreportshead', [StudentController::class, 'showreportshead'])->middleware('auth:head');
    // Make report by student route
    Route::post('/makereportstudent', [StudentController::class, 'makereportstudent'])->middleware('auth:student');
    // Make report by professor route
    // Route::post('/makereportprof', [StudentController::class, 'makereportprof'])->middleware('auth:prof');
    // Make report by department head route
    
    // Show schedule details route
    Route::post('/showscheduales/{id}', [StudentController::class, 'showscheduales'])->middleware('auth:student');
    // Research plan route
    Route::post('/researchplan', [StudentController::class, 'researchplan'])->middleware('auth:student');

    Route::post('/courses/addplan/{id}', [CourseController::class, 'addplan']); // Create a new course
    
    
    });
    // Course routes
    Route::post('/courses', [CourseController::class, 'index']); // List all courses
    Route::post('/courses', [CourseController::class, 'store']); // Create a new course
    Route::post('/courses/addmatrial/{id}', [CourseController::class, 'addmatrial']); // Create a new course
    Route::post('/courses/{course}', [CourseController::class, 'show']); // Show details of a specific course
    Route::post('/courses/{course}', [CourseController::class, 'update']); // Update a course
    Route::post('/courses/{course}', [CourseController::class, 'destroy']); // Delete a course
    
    // Protected Routes (require student or head authentication)
    
    // Protected Routes (require different admin authentications)
   
        Route::post('/addhead', [AdminController::class, 'addhead']);
        Route::post('/addprof', [AdminController::class, 'addprof']);
        Route::post('/addemployee', [AdminController::class, 'addemployee']);
        Route::post('/addvice', [AdminController::class, 'addvice']);
        Route::post('/updateAccounthead', [AdminController::class, 'updateAccounthead']);
    Route::post('/deletehead/{id}', [AdminController::class, 'deletehead']);
    
    
    Route::post('/updateAccountprof', [AdminController::class, 'updateAccountprof']);
    Route::post('/deleteprof/{id}', [AdminController::class, 'deleteprof']);
        Route::put('/updateAccountemployee', [AdminController::class, 'updateAccountemployee']);
        Route::post('/deleteemployee/{id}', [AdminController::class, 'deleteemployee']);
            Route::put('/updateAccountvice', [AdminController::class, 'updateAccountvice']);
            Route::delete('/deletevice/{id}', [AdminController::class, 'deletevice']);
            
            // Schedule routes
           
    Route::post('/schedules', [ScheduleController::class, 'index']);
    Route::post('/schedules', [ScheduleController::class, 'store']);
    Route::post('/schedules/{id}', [ScheduleController::class, 'show']);
    Route::post('/schedules/{id}', [ScheduleController::class, 'update']);
    Route::post('/schedules/{id}', [ScheduleController::class, 'destroy']);
    
    // Department routes
        Route::post('/departments', [DepartmentController::class, 'index']);
        Route::post('/departments', [DepartmentController::class, 'store']);
        Route::post('/departments/{id}', [DepartmentController::class, 'show']);
        Route::post('/departments/{id}', [DepartmentController::class, 'update']);
        Route::post('/departments/{id}', [DepartmentController::class, 'destroy']);
        
        Route::post('/addacount/{id}', [HeadController::class, 'addstudent']);
        Route::post('/rejectstudent/{id}', [HeadController::class, 'rejectstudent']);
        Route::post('/addacounts', [HeadController::class, 'addStudents']);
        Route::post('/rejectStudents', [HeadController::class, 'rejectStudents']);
        Route::post('/PendingStudent', [HeadController::class, 'PendingStudent']);

        Route::post('/addadmin', [HeadController::class, 'addadmin']);
        // routes/api.php
        Route::post('/makereporthead', [StudentController::class, 'makereporthead'])->middleware('auth:head'); 
        Route::post('/makereportprof', [StudentController::class, 'makereportprof'])->middleware('auth:prof'); 
       
        
        Route::post('/stripe', [StripeController::class, 'makePayment']); 

Route::put('/student/{student_id}/secound-term', [HeadController::class, 'secoundTerm']);
Route::put('/student/{student_id}/go-to-master', [HeadController::class, 'goToMaster']);
Route::put('/student/{student_id}/accept-in-master', [HeadController::class, 'acceptInMaster']);
Route::put('/student/{student_id}/master-done', [HeadController::class, 'masterDone']);
Route::put('/student/{student_id}/pass-general-exam', [HeadController::class, 'passgeneralexam']);


        // Catch-all route for undefined routes
        Route::fallback(function () {
            return response()->json(['message' => 'Not Found'], 404);
            });
            