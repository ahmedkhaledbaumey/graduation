<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeadController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DepartmentController;

// Authentication Routes
Route::post('/auth/login', [StudentController::class, 'login']);
Route::post('/auth/loginstudent', [AdminController::class, 'loginstudent']);
Route::post('/auth/register', [StudentController::class, 'register']);
Route::post('/addacount/{id}', [HeadController::class, 'addacount']);

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
    Route::post('/researchplan', [StudentController::class, 'researchplan']);

    // Course routes
    Route::get('/courses', [CourseController::class, 'index']); // List all courses
    Route::post('/courses', [CourseController::class, 'store']); // Create a new course
    Route::get('/courses/{course}', [CourseController::class, 'show']); // Show details of a specific course
    Route::put('/courses/{course}', [CourseController::class, 'update']); // Update a course
    Route::delete('/courses/{course}', [CourseController::class, 'destroy']); // Delete a course

    // Department routes
    Route::resource('departments', DepartmentController::class)->except(['create', 'edit']); // Resourceful routes for departments

    // Head-specific routes
    Route::post('/heads/addgrade/{id}', [HeadController::class, 'addGrade']); // Add grade for a course student
    Route::post('/heads/addaccount/{student_id}', [HeadController::class, 'addAccount']); // Add email account for a student
});

// Catch-all route for undefined routes
Route::fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});
