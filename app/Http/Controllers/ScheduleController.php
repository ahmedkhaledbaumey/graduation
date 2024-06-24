<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Schedules = Schedule::all();
        return response()->json($Schedules);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request parameters for schedule creation
        $validatedData = $request->validate([
            'type' => 'required|in:exam,study',
            'content' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt', // Validate 'content' as a file with specified mime types
        ]);
    
        // Process and store the content file if it exists
        if ($request->hasFile('content')) {
            $filePath = $request->file('content')->store('public/schedule_content');
            $validatedData['content'] = $filePath;
        }
    
        // Create a new schedule record in the 'schedules' table
        $schedule = Schedule::create($validatedData);
    
        // Generate URL for the stored file
        if (isset($filePath)) {
            $fileUrl = Storage::url($filePath);
            $schedule->content_url = $fileUrl;
        }
    
        // Return a success response with the created schedule details
        return response()->json($schedule, 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Schedule = Schedule::findOrFail($id);
        return response()->json($Schedule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateschedule(Request $request, $id)
    {
        $Schedule = Schedule::findOrFail($id);

        $validatedData = $request->validate([
            'type' => 'required|in:exam,study',
            'content' => 'nullable|string',
        ]);

        $Schedule->update($validatedData);

        return response()->json($Schedule, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyschedules($id)
    {
        $Schedule = Schedule::findOrFail($id);
        $Schedule->delete();

        return response()->json(['message' => 'Schedule deleted successfully'], 200);
    }
}