<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HeadController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AdminController;

// Authentication Routes
Route::post('/auth/loginstudent', [AdminController::class, 'loginstudent']);
Route::post('/auth/login', [StudentController::class, 'login']);
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
    Route::get('/auth/user-profile', [StudentController::class, 'userProfile']);
    // Enroll courses route
    Route::post('/courses/enroll', [StudentController::class, 'enrollCourses']);
    // Show grade route
    Route::get('/showgrade', [StudentController::class, 'showgrade']);
    // Show courses route
    Route::get('/showcourses', [StudentController::class, 'showcourses']);
    // Show reports route
    Route::get('/showreports', [StudentController::class, 'showreports']);
    // Show specific report for student route
    Route::get('/showreportsstudent', [StudentController::class, 'showreportsstudent']);
    // Show specific report for professor route
    Route::get('/showreportsprof', [StudentController::class, 'showreportsprof']);
    // Show specific report for department head route
    Route::get('/showreportshead', [StudentController::class, 'showreportshead']);
    // Make report by student route
    Route::post('/makereportstudent', [StudentController::class, 'makereportstudent']);
    // Make report by professor route
    Route::post('/makereportprof', [StudentController::class, 'makereportprof']);
    // Make report by department head route
    Route::post('/makereporthead', [StudentController::class, 'makereporthead']);
    // Show schedule details route
    Route::get('/showscheduales/{id}', [StudentController::class, 'showscheduales']);
    // Research plan route
    Route::get('/researchplan', [StudentController::class, 'researchplan']);

    // Course routes
    Route::get('/courses', [CourseController::class, 'index']); // List all courses
    Route::post('/courses', [CourseController::class, 'store']); // Create a new course
    Route::get('/courses/{course}', [CourseController::class, 'show']); // Show details of a specific course
    Route::put('/courses/{course}', [CourseController::class, 'update']); // Update a course
    Route::delete('/courses/{course}', [CourseController::class, 'destroy']); // Delete a course
});

// Protected Routes (require student or head authentication)
Route::middleware('auth:student,head')->group(function () {
    Route::post('/addhead', [AdminController::class, 'addhead']);
});

// Protected Routes (require different admin authentications)
Route::middleware('auth:head')->group(function () {
    Route::post('/addprof', [AdminController::class, 'addprof']);
    Route::post('/addemployee', [AdminController::class, 'addemployee']);
    Route::post('/addvice', [AdminController::class, 'addvice']);
    Route::put('/updateAccounthead', [AdminController::class, 'updateAccounthead']);
    Route::delete('/deletehead/{id}', [AdminController::class, 'deletehead']);
});
Route::middleware('auth:prof')->group(function () {
    Route::put('/updateAccountprof', [AdminController::class, 'updateAccountprof']);
    Route::delete('/deleteprof/{id}', [AdminController::class, 'deleteprof']);
});
Route::middleware('auth:employee')->group(function () {
    Route::put('/updateAccountemployee', [AdminController::class, 'updateAccountemployee']);
    Route::delete('/deleteemployee/{id}', [AdminController::class, 'deleteemployee']);
});
Route::middleware('auth:vice_dean')->group(function () {
    Route::put('/updateAccountvice', [AdminController::class, 'updateAccountvice']);
    Route::delete('/deletevice/{id}', [AdminController::class, 'deletevice']);
});

// Schedule routes
Route::middleware('auth:student')->group(function () {
    Route::get('/schedules', [ScheduleController::class, 'index']);
    Route::post('/schedules', [ScheduleController::class, 'store']);
    Route::get('/schedules/{id}', [ScheduleController::class, 'show']);
    Route::put('/schedules/{id}', [ScheduleController::class, 'update']);
    Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy']);
});

// Department routes
Route::middleware('auth:student')->group(function () {
    Route::get('/departments', [DepartmentController::class, 'index']);
    Route::post('/departments', [DepartmentController::class, 'store']);
    Route::get('/departments/{id}', [DepartmentController::class, 'show']);
    Route::put('/departments/{id}', [DepartmentController::class, 'update']);
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy']);
});

// Catch-all route for undefined routes
Route::fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});
