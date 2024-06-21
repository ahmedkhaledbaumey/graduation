<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\Admin;
use App\Models\Course;
use App\Models\Report;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\CourseStudent;
use Mockery\Generator\Method;
use Illuminate\Support\Facades\Auth;

class HeadController extends Controller
{
    public function addgrade(Request $request, $id)
    {
        $course_id = $request->course_id;
        // ابحث عن سجل CourseStudent معين بناءً على معرف الطالب
        $student = CourseStudent::where('student_id', $id)->where('course_id', $course_id)->firstOrFail();

        // حدث حقل الدرجة في السجل المحدد
        $student->grade = $request->grade;
        $student->save();

        return response()->json(['message' => 'Grade Added Successfully.'], 200);
    }




    public function allenrolled()
    {

        $students = CourseStudent::get();
        if ($students) {
            return response()->json($students, 200);
        } else {
            return response()->json(['message' => 'No Students Found.'], 404);
        }
    }
    public function PendingStudent()
    {

        $students = Student::with('studentPhotos')->where('status', 'pending')->get();
        if ($students) {
            return response()->json($students, 200);
        } else {
            return response()->json(['message' => 'No Students Found.'], 404);
        }
    }
    public function rejectstudent($student_id)
    {
        $student = Student::findOrFail($student_id);

        // Generate an email account based on student's name and domain
        // $student->account = $student->name . "@fci.bu.edu.eg";
        if ($student->status == 'pending') {
            $status = "rejected";
            // Generate a random password (you may adjust this logic as needed)
            // $randomPassword = $student->SSN;

            // $student->password = bcrypt($randomPassword);
            $student->status = $status;


            if ($student->save()) {
                return response()->json(
                    [
                        'message' => 'student rejected successfully.',
                        // 'password' => $randomPassword ,             'account' => $student->account
                    ],
                    200
                );
            }
        } else {
            return response()->json(['error' => 'Failed to add account.'], 400);
        }
    }
    public function addstudent($student_id)
    {
        $student = Student::findOrFail($student_id);

        // Generate an email account based on student's name and domain
        $student->account = str_replace(' ', '', trim($student->english_name)) . "@fci.bu.edu.eg";

        $status = "accept";
        // Generate a random password (you may adjust this logic as needed)
        $randomPassword = $student->SSN;

        $student->password = bcrypt($randomPassword);
        $student->status = $status;
        $student->time = 'first';


        if ($student->save()) {
            return response()->json(
                [
                    'message' => 'Account added successfully.',
                    'password' => $randomPassword,             'account' => $student->account
                ],
                200
            );
        } else {
            return response()->json(['error' => 'Failed to add account.'], 400);
        }
    }

    public function addStudents(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'student_ids' => 'required|array', // Ensure 'student_ids' is an array
            'student_ids.*' => 'exists:students,id' // Ensure each ID exists in the 'students' table
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $studentIds = $request->input('student_ids');
        $results = [];

        foreach ($studentIds as $student_id) {
            $student = Student::find($student_id);

            if ($student) {
                // Generate an email account based on student's name and domain
                $student->account = $student->name . "@fci.bu.edu.eg";
                $status = "accept";
                // Generate a random password (you may adjust this logic as needed)
                $randomPassword = $student->SSN;

                $student->password = bcrypt($randomPassword);
                $student->status = $status;

                if ($student->save()) {
                    $results[] = [
                        'student_id' => $student_id,
                        'message' => 'Account added successfully.',
                        'password' => $randomPassword,
                        'account' => $student->account
                    ];
                } else {
                    $results[] = [
                        'student_id' => $student_id,
                        'error' => 'Failed to add account.'
                    ];
                }
            } else {
                $results[] = [
                    'student_id' => $student_id,
                    'error' => 'Student not found.'
                ];
            }
        }

        return response()->json($results, 200);
    }
    public function rejectStudents(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'student_ids' => 'required|array', // Ensure 'student_ids' is an array
            'student_ids.*' => 'exists:students,id' // Ensure each ID exists in the 'students' table
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $studentIds = $request->input('student_ids');
        $results = [];

        foreach ($studentIds as $student_id) {
            $student = Student::find($student_id);


            if ($student) {
                if ($student->status == 'pending') {

                    // Generate an email account based on student's name and domain
                    // $student->account = $student->name . "@fci.bu.edu.eg";
                    $status = "rejected";
                    // Generate a random password (you may adjust this logic as needed)
                    $randomPassword = $student->SSN;

                    $student->password = bcrypt($randomPassword);
                    $student->status = $status;

                    if ($student->save()) {
                        $results[] = [
                            'student_id' => $student_id,
                            'message' => 'student rejected successfully.',
                            // 'password' => $randomPassword,
                            // 'account' => $student->account
                        ];
                    }
                } else {
                    $results[] = [
                        'student_id' => $student_id,
                        'error' => 'Failed to add account.'
                    ];
                }
            } else {
                $results[] = [
                    'student_id' => $student_id,
                    'error' => 'Student not found.'
                ];
            }
        }

        return response()->json($results, 200);
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


    public function adminlogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->guard('admin')->attempt($validator->validated())) {
            return response()->json(['error' => 'invalid datag'], 401);
        }
        return $this->createNewToken($token);
    }
    public function headlogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->guard('head')->attempt($validator->validated())) {
            return response()->json(['error' => 'invalid datag'], 401);
        }
        return $this->createNewToken($token);
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 600000000000000000,
            // 'user' => auth()->user() // Return the authenticated user's data in the response
        ]);
    }

    public function secoundTerm($student_id)
    {
        $student = Student::findOrFail($student_id);
        $student->time = 'last';
        if ($student->save()) {
            return response()->json(
                [
                    'message' => 'student  become in secound term.',
                ],
                200
            );
        } else {
            return response()->json(['error' => 'Failed to add account.'], 400);
        }
    }
    public function goToMaster($student_id)
    {
        $student = Student::findOrFail($student_id);
        $student->time = 'null';
        $student->level = 'null';
        $student->status = 'pending';
        if ($student->save()) {
            return response()->json(
                [
                    'message' => 'student  finish  study .',
                ],
                200
            );
        } else {
            return response()->json(['error' => 'Failed to add account.'], 400);
        }
    }
    public function acceptInMaster($student_id)
    {
        $student = Student::findOrFail($student_id);
        $student->time = 'null';
        $student->level = 'second_level';
        $student->status = 'accept';
        if ($student->save()) {
            return response()->json(
                [
                    'message' => 'student  finish  study .',
                ],
                200
            );
        } else {
            return response()->json(['error' => 'Failed to add account.'], 400);
        }
    }
    public function masterDone($student_id)
    {
        $student = Student::findOrFail($student_id);
        $student->time = 'null';
        $student->level = 'null';
        $student->status = 'pending';
        $student->degree = 'phd';

        if ($student->save()) {
            return response()->json(
                [
                    'message' => 'student  finish  study .',
                ],
                200
            );
        } else {
            return response()->json(['error' => 'Failed to add account.'], 400);
        }
    }
    public function passgeneralexam($student_id)
    {
        $student = Student::findOrFail($student_id);

        $student->status = 'accept';
        $student->generalexam = 'done';

        if ($student->save()) {
            return response()->json(
                [
                    'message' => 'student  finish  study .',
                ],
                200
            );
        } else {
            return response()->json(['error' => 'Failed to add account.'], 400);
        }
    }  



//accepts reports 

    public function acceptReport($repoet_id) 
    { 
        $report = Report::findOrFail($repoet_id); 
        if(auth()->user()->id==$report->id){
        $report->status = 'approved';
        if ($report->save()) {
            return response()->json(
                [
                   'message' =>'report  accept .',
                ],
                200
            );
        } else {
            return response()->json(['error' => 'Failed to add account.'], 400);
        } 
    } 
    else {
        return response()->json(['error' => ' action unauthorized.'], 400);
    } 

    }





}
