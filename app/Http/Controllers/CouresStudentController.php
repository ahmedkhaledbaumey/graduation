<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseStudent;
use Validator;

class CouresStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $courseStudents = CourseStudent::all();
        return response()->json($courseStudents);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        // إرجاع عرض الإنشاء إذا لزم الأمر
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // تحقق من صحة البيانات المدخلة
        $validator = Validator::make($request->all(), [
            'grade' => 'required|string',
            'firstOrSecond' => 'required|in:first,second',
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        // إذا فشل التحقق، أرجع أخطاء الصحة
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // إنشاء سجل CourseStudent في قاعدة البيانات
        $courseStudent = CourseStudent::create($validator->validated());

        return response()->json($courseStudent, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseStudent  $courseStudent
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(CourseStudent $courseStudent)
    {
        return response()->json($courseStudent);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseStudent  $courseStudent
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(CourseStudent $courseStudent)
    {
        // إرجاع عرض التحرير إذا لزم الأمر
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseStudent  $courseStudent
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, CourseStudent $courseStudent)
    {
        // تحقق من صحة البيانات المدخلة
        $validator = Validator::make($request->all(), [
            'grade' => 'required|string',
            'firstOrSecond' => 'required|in:first,second',
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        // إذا فشل التحقق، أرجع أخطاء الصحة
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // تحديث بيانات سجل CourseStudent في قاعدة البيانات
        $courseStudent->update($validator->validated());

        return response()->json($courseStudent, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseStudent  $courseStudent
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CourseStudent $courseStudent)
    {
        // حذف سجل CourseStudent من قاعدة البيانات
        $courseStudent->delete();

        return response()->json(null, 204);
    } 
}
