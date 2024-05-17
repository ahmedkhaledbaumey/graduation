<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\CourseStudent;
use App\Models\Department;

class HeadController extends Controller
{
    public function addgrade(Request $request, $id)
    {
        $student = CourseStudent::findOrFail($id); 

        $student->grade = $request->grade; 
        $student->save();  
        return response()->json(['message' => 'Grade Added Successfully.'], 404);
    } 
    public function addrecearchplan(Request $request, $id)
    {
        $department = Department::findOrFail($id); 

        $department->research_plan = $request->research_plan; 
        $department->save();  
        return response()->json(['message' => 'Grade Added Successfully.'], 404);
    } 

    public function addstudent($student_id)
    {   
        $student = Student::findOrFail($student_id);
    
        // Generate an email account based on student's name and domain
        $student->account = $student->name . "@fci.bu.edu.eg";
         $status = "accept" ; 
        // Generate a random password (you may adjust this logic as needed)
        $randomPassword = $student->SSN; 
         
        $student->password = bcrypt($randomPassword); 
        $student->status = $status; 

    
        if ($student->save()) {
            return response()->json(['message' => 'Account added successfully.', 'password' => $randomPassword], 200);
        } else {
            return response()->json(['error' => 'Failed to add account.'], 400);
        }
    }
    
}
