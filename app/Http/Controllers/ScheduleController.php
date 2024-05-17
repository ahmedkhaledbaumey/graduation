<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

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
        $validatedData = $request->validate([
            'type' => 'required|in:exam,study',
            'content' => 'nullable|string',
        ]);

        $Schedule = Schedule::create($validatedData);

        return response()->json($Schedule, 201);
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
    public function update(Request $request, $id)
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
    public function destroy($id)
    {
        $Schedule = Schedule::findOrFail($id);
        $Schedule->delete();

        return response()->json(['message' => 'Schedule deleted successfully'], 200);
    }
}