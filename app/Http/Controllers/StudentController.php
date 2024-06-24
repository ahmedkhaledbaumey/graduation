<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Validator;
use App\Models\Head;
use App\Models\Prof;
use App\Models\Report;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\CourseStudent;
use App\Models\StudentPhotos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    /**
     * Create a new instance of StudentController.
     *
     * @return void
     */
    public function __construct()
    {
        // Apply middleware to protect routes, except for login and register
        // $this->middleware('auth:student', ['except' => ['login', 'register' ,'makereporthead','makereportprof' ,]]);
    }

    /**
     * Get a JSON Web Token (JWT) via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'invalid datag'], 401);
        }
        return $this->createNewToken($token);
    }
    public function loginstudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account' => 'required|email',
            'SSN' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'invalid datag'], 401);
        }
        return $this->createNewToken($token);
    }

    /**
     * Register a new User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

     public function register(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'original_bachelors_degree' => 'nullable|file|mimes:jpg,jpeg,png',
             'personalImage' => 'nullable|file|mimes:jpg,jpeg,png',
             'master_degree' => 'nullable|file|mimes:jpg,jpeg,png',
             'BirthCertificate' => 'nullable|file|mimes:jpg,jpeg,png',
             'IDCardCopy' => 'nullable|file|mimes:jpg,jpeg,png',
             'RecruitmentPosition' => 'nullable|file|mimes:jpg,jpeg,png',
             'EmployerApproval' => 'nullable|file|mimes:jpg,jpeg,png',
             'superAccpet' => 'nullable|file|mimes:jpg,jpeg,png',
             'four_years_grades' => 'nullable|file|mimes:jpg,jpeg,png',
             'name' => 'required|string|between:2,100',
             'english_name' => 'required|string|between:2,100',
             'nationality' => 'required|string|between:2,100',
             'religion' => 'required|string|between:2,100',
             'job' => 'required|string|between:2,100',
             'age' => 'required|integer',
             'SSN' => 'required|string|between:2,100|unique:students,SSN',
             'phone' => 'required|string|between:2,100',
             'address' => 'required|string',
             'department_id' => 'required|in:1,2,3,4',
             'gender' => 'required|string',
             'marital_status' => 'required|string',
             'idea' => 'nullable|string',
             'email' => 'required|string|email|max:100|unique:students,email',
             'type' => 'required|in:' . implode(',', Student::type),
         ]);
     
         if ($validator->fails()) {
             return response()->json($validator->errors()->toJson(), 400);
         }
     
         $files = [
             'original_bachelors_degree', 'personalImage', 'four_years_grades',
             'master_degree', 'BirthCertificate', 'IDCardCopy', 'RecruitmentPosition',
             'EmployerApproval', 'superAccpet'
         ];
         
         $filePaths = [];
         
         foreach ($files as $file) {
             if ($request->hasFile($file)) {
                 $filePaths[$file] = $request->file($file)->store('students/' . $file);
             } else {
                 $filePaths[$file] = null;
             }
         }
     
         $paymentStatus = $request->input('type') === 'moed' ? 'complete' : 'pending';
         $time = $request->input('type') === 'moed' ? 'first' : 'null';
         $degree = $request->has('original_bachelors_degree') ? 'phd' : 'master';
     
         $student = Student::create(array_merge(
             $validator->validated(),
             [
                 'password' => bcrypt($request->password),
                 'payment' => $paymentStatus,
                 'time' => $time,
                 'degree' => $degree,
             ]
         ));
     
         $studentPhotos = new StudentPhotos(array_merge(
             ['student_id' => $student->id],
             $filePaths
         ));
         $studentPhotos->save();
     
         return response()->json([
             'message' => 'User successfully registered',
             'student' => $student,
             'student_photos' => $studentPhotos
         ], 201);
     }
     
    //base 64 
    //     public function register(Request $request)
    // {
    //     // Validate the request parameters for user registration
    //     $validator = Validator::make($request->all(), [
    //         'enrollment_papers.*' => 'required|string', // Validating multiple image uploads as Base64 strings
    //         'original_bachelors_degree' => 'nullable|string', // Validating the original bachelor's degree as a Base64 string
    //         'image' => 'required|string', // Validating the student's image as a Base64 string
    //         'name' => 'required|string|between:2,100',
    //         'english_name' => 'required|string|between:2,100',
    //         'nationality' => 'required|string|between:2,100',
    //         'religion' => 'required|string|between:2,100',
    //         'job' => 'required|string|between:2,100',
    //         'age' => 'required|integer', // Assuming age is an integer
    //         'SSN' => 'required|string|between:2,100|unique:students,SSN', // Ensure SSN uniqueness in the 'students' table
    //         'phone' => 'required|string|between:2,100',
    //         'address' => 'required|string',
    //         'department_id' => 'required|in:1,2,3,4',
    //         'gender' => 'required|string', // Validating against specific genders
    //         'marital_status' => 'required|string', // Validating against specific marital statuses
    //         'idea' => 'nullable|string', // Assuming idea is optional
    //         'email' => 'required|string|email|max:100|unique:students,email', // Ensure email uniqueness in the 'students' table
    //         'type' => 'required|in:' . implode(',', Student::type), // Validate 'type' field against predefined options in the Student model
    //     ]);

    //     // If validation fails, return errors
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors()->toJson(), 400);
    //     }

    //     // Process enrollment papers (multiple Base64 strings)
    //     $enrollmentPapers = [];
    //     foreach ($request->input('enrollment_papers') as $base64Image) {
    //         $image = base64_decode($base64Image);
    //         $path = 'student/enrollment_papers/' . uniqid() . '.jpg';
    //         Storage::put($path, $image);
    //         $enrollmentPapers[] = $path;
    //     }

    //     // Process original bachelor's degree (single Base64 string)
    //     $originalBachelorsDegree = base64_decode($request->input('original_bachelors_degree'));
    //     $originalBachelorsDegreePath = 'student/original_bachelors_degree/' . uniqid() . '.jpg';
    //     Storage::put($originalBachelorsDegreePath, $originalBachelorsDegree);

    //     // Process student image (single Base64 string)
    //     $image = base64_decode($request->input('image'));
    //     $imagePath = 'student/images/' . uniqid() . '.jpg';
    //     Storage::put($imagePath, $image);

    //     // Check if type is 'moed' and set payment to 'complete'
    //     $paymentStatus = $request->input('type') === 'moed' ? 'complete' : 'pending';
    //     $time = $request->input('type') === 'moed' ? 'first' : 'null';

    //     // Check if original_bachelors_degree is present and set degree to 'phd'
    //     $degree = $request->has('original_bachelors_degree') ? 'phd' : 'master';

    //     // Debugging: Check if the degree is set correctly
    //     if ($request->has('original_bachelors_degree')) {
    //         Log::info('Original Bachelor\'s Degree is present. Setting degree to phd.');
    //     } else {
    //         Log::info('Original Bachelor\'s Degree is not present. Setting degree to master.');
    //     }

    //     // Create a new student record in the 'students' table
    //     $student = Student::create(array_merge(
    //         $validator->validated(),
    //         [
    //             'password' => bcrypt($request->password),
    //             'payment' => $paymentStatus,
    //             'time' => $time,
    //             'degree' => $degree,
    //             'image' => $imagePath,
    //         ]
    //     ));

    //     // Create a new student_photos record in the 'student_photos' table
    //     $studentPhotos = new StudentPhotos([
    //         'student_id' => $student->id,
    //         'enrollment_papers' => json_encode($enrollmentPapers), // Store uploaded files' paths as JSON
    //         'original_bachelors_degree' => $originalBachelorsDegreePath, // Store the uploaded file's path
    //         'image' => $imagePath, // Store the uploaded file's path
    //     ]);
    //     $studentPhotos->save();

    //     // Return a success response with the created student details
    //     return response()->json([
    //         'message' => 'User successfully registered',
    //         'student' => $student,
    //         'student_photos' => $studentPhotos,
    //     ], 201);
    // }








    /**
     * Log out the authenticated user (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout(); // Log out the authenticated user
        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a JSON Web Token (JWT).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh()); // Refresh the token and return a new JWT
    }

    /**
     * Get the authenticated User profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        $student = auth()->user()->load('studentPhotos');

        return response()->json([
            'student' => $student,

            // 'student_photos' => $student->studentPhotos
        ], 201); // Return the authenticated user's profile data
    }
    /**
     * Create a new JWT response.
     *
     * @param  string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard("student")->factory()->getTTL() * 600000000000000000,
            // 'user' => auth()->user() // Return the authenticated user's data in the response
        ]);
    }

    /**
     * Enroll the authenticated Student in courses.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function enrollCourses(Request $request)
    {
        // Validate the request parameters
        $validator = Validator::make($request->all(), [
            'course_ids' => 'required|array', // مصفوفة من معرفات المقررات
            'course_ids.*' => 'integer|exists:courses,id', // تحقق من وجود كل معرف مقرر في جدول المقررات
        ]);
    
        // إذا فشل التحقق، يتم إرجاع أخطاء الصحة
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
    
        // الحصول على الطالب المصادق عليه
        $student = auth()->user();
    
        // ربط المقررات المطلوبة بالطالب دون إزالة المقررات الحالية
        $student->courses()->syncWithoutDetaching($request->course_ids);
    
        return response()->json([
            'message' => 'Courses successfully enrolled',
        ], 201);
    } 
    public function unenrollCourse(Request $request)
{
    // Validate the request parameters
    $validator = Validator::make($request->all(), [
        'course_id' => 'required|integer|exists:courses,id', // تحقق من وجود معرف المقرر في جدول المقررات
    ]);

    // إذا فشل التحقق، يتم إرجاع أخطاء الصحة
    if ($validator->fails()) {
        return response()->json($validator->errors()->toJson(), 400);
    }

    // الحصول على الطالب المصادق عليه
    $student = auth()->user();

    // إلغاء تسجيل الطالب من المادة
    $student->courses()->detach($request->course_id);

    return response()->json([
        'message' => 'Course successfully unenrolled',
    ], 200);
}
    



    public function showgrade()
    {
        $id = auth()->user()->id;
        $department = CourseStudent::where('student_id', $id)->get();
        return response()->json($department);
    }
    public function showcourses()
    {
        // الحصول على معرف الطالب المعتمد
        $userId = auth()->user()->id;

        // البحث عن سجلات طالب المقررات باستخدام معرف الطالب
        $courses = CourseStudent::where('student_id', $userId)->with('course')->get();

        // إرجاع البيانات كـ JSON
        return response()->json($courses);
    }
    public function showallcourses()
    {
        // الحصول على معرف الطالب المعتمد

        // البحث عن سجلات طالب المقررات باستخدام معرف الطالب
        $courses = Course::get();

        // إرجاع البيانات كـ JSON
        return response()->json($courses);
    }



    public function showcoursesForDepartment()
    {
        // الحصول على المستخدم المصادق عليه
        $user = auth()->user();

        // الحصول على الوقت ومعرف القسم للمستخدم المصادق عليه
        $time = $user->time;
        $department_id = $user->department_id;

        // الحصول على الدورات التي تتطابق مع الوقت ومعرف القسم
        $courses = Course::where('time', $time)->where('department_id', $department_id)->get();

        // إعادة النتيجة كاستجابة JSON
        return response()->json($courses);
    }

    // public function showreports()
    // {
    //     $head_id = auth()->user()->id;
    //     // احصل على تقارير مع اسم الطالب فقط
    //     $reports = Report::with(['student' => function ($query) {
    //         $query->select('id', 'name');
    //     }])->where('head_id', $head_id)->get();

    //     // تعديل البيانات لإرجاع اسم الطالب فقط مع التقرير
    //     // $reportsWithStudentName = $reports->map(function($report) {
    //     //     return [
    //     //         'report_id' => $report->id,
    //     //         'report_content' => $report->content,
    //     //         'student_name' => $report->student->name
    //     //     ];
    //     // });

    //     return response()->json($reports);
    // }

    public function showreports()
{
    $head_id = auth()->user()->id;

    // احصل على تقارير مع اسم الطالب فقط
    $reports = Report::with(['student' => function ($query) {
        $query->select('id', 'name');
    }])->where('head_id', $head_id)->get();

    // تعديل البيانات لإرجاع جميع الحقول بدون الحقول التي تحتوي على null
    $filteredReports = $reports->map(function($report) {
        // تحويل التقرير إلى مصفوفة
        $reportArray = $report->toArray();

        // إزالة الحقول التي تحتوي على null
        $reportArray = array_filter($reportArray, function($value) {
            return !is_null($value);
        });

        // نفس الشيء للطالب المرتبط بالتقرير
        if (isset($reportArray['student'])) {
            $reportArray['student'] = array_filter($reportArray['student'], function($value) {
                return !is_null($value);
            });
        }

        return $reportArray;
    });

    return response()->json($filteredReports);
}



   

    public function showreportsstudent()
    {
        $student = auth()->user(); // Get the authenticated user (student)

        // Check if the student belongs to any department
        if ($student->department) {
            $head_id = $student->department->head_id;

            // Find the report for the student with the specified head_id
            $report = Report::where('student_id', $student->id)

                ->get();

            if ($report) {
                return response()->json($report);
            } else {
                return response()->json(['message' => 'Report not found.'], 404);
            }
        } else {
            return response()->json(['message' => 'Student does not belong to any department.'], 404);
        }
    }
    public function showreportsprof()
    {
        $prof = auth()->user(); // Get the authenticated user (prof)

        // Check if the student belongs to any department
        if ($prof->department) {
            // $head_id = $prof->department->head_id;

            // Find the report for the student with the specified head_id
            $report = Report::where('prof_id', $prof->id)

                ->get();

            if ($report) {
                return response()->json($report);
            } else {
                return response()->json(['message' => 'Report not found.'], 404);
            }
        } else {
            return response()->json(['message' => 'Student does not belong to any department.'], 404);
        }
    }
    public function showreportshead()
    {
        $head = auth()->user(); // Get the authenticated user (head)

        // Check if the student belongs to any department
        // if ($head->department) {
        //     $head_id = $head->department->head_id;

        // Find the report for the student with the specified head_id
        $report = Report::where('head_id', $head->id)

            ->get();

        if ($report) {
            return response()->json($report);
        } else {
            return response()->json(['message' => 'Report not found.'], 404);
        }
        // } else {
        //     return response()->json(['message' => 'Student does not belong to any department.'], 404);
        // }
    }

    public function makereportstudent(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'type' => 'required|string',
            'date' => 'required|date',
            // 'prof_id' => '|exists:profs,id', // Ensure the provided professor ID exists
            // 'department_id' => 'required|exists:departments,id', // Ensure the provided department ID exists
        ]);
        if ($request->input('type') == 'provideresearchpoint') {
            $validator = Validator::make($request->all(), [
                'researchpoint' => 'required|string',

            ]);
        }
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Get the authenticated student 
        $student_id = auth()->user()->id;
        $student = Student::find($student_id);
        $head_id = $student->department->head_id;

        // Create a new Report instance with validated data
        $report = new Report([
            'content' => $request->input('content'),
            'type' => $request->input('type'),
            'date' => $request->input('date'),
            'researchpoint' => $request->input('researchpoint'),
            // 'prof_id' => $request->input('prof_id'),
            'head_id' => $head_id,
            'student_id' => $student->id,
            'status' => 'pending',
        ]);

        // Save the report to the database
        $report->save();

        // Return a JSON response indicating success
        return response()->json([
            'message' => 'Report created successfully',
            'report' => $report,
        ], 201);
    }
    public function makereportprof(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'type' => 'required|string',
            'date' => 'required|date',
            // 'prof_id' => 'required|exists:profs,id', // Ensure the provided professor ID exists
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Get the authenticated professor
        $prof_id = auth()->user()->id;
        $prof = Prof::find($prof_id);
        $department = $prof->department; // Load the department model
        $head_id = $department->head_id; // Access the head_id property

        // Create a new Report instance with validated data
        $report = new Report([
            'content' => $request->input('content'),
            'type' => $request->input('type'),
            'date' => $request->input('date'),
            'head_id' => $head_id,
            'prof_id' => $prof->id,
            'status' => 'pending',

        ]);

        // Save the report to the database
        $report->save();

        // Return a JSON response indicating success
        return response()->json([
            'message' => 'Report created successfully',
            'report' => $report,
        ], 201);
    }

    public function makereporthead(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'type' => 'required|string',
            'date' => 'required|date',

        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Get the authenticated user (assuming it's a head of department)
        $head_id = auth()->user()->id;

        // Create a new Report instance with validated data
        $report = new Report([
            'content' => $request->input('content'),
            'type' => $request->input('type'),
            'date' => $request->input('date'),
            // 'prof_id' => $request->input('prof_id'),
            'head_id' => $head_id,
            'status' => 'pending',

        ]);

        // Save the report to the database
        $report->save();

        // Return a JSON response indicating success
        return response()->json([
            'message' => 'Report created successfully',
            'report' => $report,
        ], 201);
    }

    public function showscheduales($id)
    {
        // $id = auth()->user()->id  ;
        $sceduals = Schedule::findOrFail($id);
        return response()->json($sceduals);
    }

    public function researchplan()
    {
        // Get the authenticated user (student)
        $student = auth()->user();

        // Check if the student belongs to any department
        if ($student->department) {
            // Retrieve the research plan from the associated department
            $researchPlan = $student->department->research_plan;

            return response()->json([
                'research_plan' => $researchPlan,
            ]);
        } else {
            return response()->json([
                'error' => 'Student does not belong to any department.',
            ], 404);
        }
    }
    // public function addresearchplan($researchPlan)
    // {
    //     // Get the authenticated user (student)
    //     $head = request()->user()->id;
    //     $department = Department::where('head_id', $head);
    //     $department->research_plan = $researchPlan;

    //     // Check if the student belongs to any department

    //     return response()->json([
    //         'message' => 'addResearch success',
    //     ], 404);
    // }
    public function updateAccount(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'email' => 'required|email|unique:students,email,' . Auth::user()->id,
            'name' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:6', // Validate password confirmation and length
        ]);

        // Retrieve the user from the database
        $user = Student::where('email', $validated['email'])->first();

        // Check if any data has changed
        if ($user->name === $validated['name'] && $user->email === $validated['email']) {
            return response()->json([
                'message' => 'No changes were made.',
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $user->password,
                ],
            ]);
        }

        // Update the user's data
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Save the changes
        $user->save();

        // Return a success message
        return response()->json([
            'message' => 'Account updated successfully.',
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}
