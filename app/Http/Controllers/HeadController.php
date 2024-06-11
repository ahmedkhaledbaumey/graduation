<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\Admin;
use App\Models\Course;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\CourseStudent; 
use Illuminate\Support\Facades\Auth;


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
        $status = "accept";
        // Generate a random password (you may adjust this logic as needed)
        $randomPassword = $student->SSN;

        $student->password = bcrypt($randomPassword);
        $student->status = $status;


        if ($student->save()) {
            return response()->json(
                [
                    'message' => 'Account added successfully.',
                    'password' => $randomPassword,             'email' => $student->account
                ],
                200
            );
        } else {
            return response()->json(['error' => 'Failed to add account.'], 400);
        }
    }
    public function addadmin(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|string|email|max:100|unique:admins,email', // Ensure email uniqueness in the 'students' table
            'password' => 'required|string', // Ensure email uniqueness in the 'students' table
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }


        Admin::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
                'email' => $request->email

            ]
        ));



        return response()->json(
            [
                'message' => 'Account added successfully.'

            ],
            200
        );
        return response()->json(['error' => 'Failed to add account.'], 400);
    } 


    public function adminlogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->guard('admin')->attempt($validator->validated())) {
            return response()->json(['error' => 'invalid datag'], 401);
        }
        return $this->createNewToken($token);
    } 
    public function headlogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->guard('head')->attempt($validator->validated())) {
            return response()->json(['error' => 'invalid datag'], 401);
        }
        return $this->createNewToken($token);
    } 

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 600000000000000000,
            // 'user' => auth()->user() // Return the authenticated user's data in the response
        ]);
    } 
}
