<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $courses = Course::all();
        return response()->json($courses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'code' => 'required|string|unique:courses,code',
            'name' => 'required|string',
            'hours' => 'required|integer',
            'material' => 'string|nullable',
            'time' => 'required|string|in:first,last',
            'chose' => 'required|string|in:elective,non_elective',
        ]);

        // Create a new course record
        $course = Course::create($validatedData);

        return response()->json($course, 201);
    }
    public function addmatrial(Request $request, $id)
{
    // Validate request data
    $validator = Validator::make($request->all(), [
        'material' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip', // Validate the material as a file with specific mime types
    ]);

    // If validation fails, return errors
    if ($validator->fails()) {
        return response()->json($validator->errors()->toJson(), 400);
    }

    // Process the material file
    $material = $request->file('material');
    $materialPath = 'course/materials/' . uniqid() . '.' . $material->getClientOriginalExtension();
    Storage::put($materialPath, file_get_contents($material));

    // Find the course and update the material field
    $course = Course::findOrFail($id);
    $course->material = $materialPath;
    $course->save();

    return response()->json([
        'message' => 'Material Added Successfully.',
        'course' => $course
    ], 201);
}

  

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Course $course)
    {
        return response()->json($course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Course $course)
    {
        // Validate request data
        $validatedData = $request->validate([
            'code' => 'required|string|unique:courses,code,' . $course->id,
            'name' => 'required|string',
            'hours' => 'required|integer',
            'material' => 'string|nullable',
        ]);

        // Update the course record
        $course->update($validatedData);

        return response()->json($course, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Course $course)
    {
        // Delete the course record
        $course->delete();

        return response()->json(null, 204);
    }
}
