<?php
namespace App\Http\Controllers;

use Validator;
use App\Models\Report;
use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\CourseStudent;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Create a new instance of StudentController.
     *
     * @return void
     */
    public function __construct() {
        // Apply middleware to protect routes, except for login and register
        $this->middleware('auth:student', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JSON Web Token (JWT) via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
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
    public function register(Request $request) {
        // Validate the request parameters for user registration
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'english_name' => 'required|string|between:2,100',
            'nationality' => 'required|string|between:2,100',
            'religion' => 'required|string|between:2,100',
            'job' => 'required|string|between:2,100',
            // 'last_name' => 'required|string|between:2,100',
            'age' => 'required|string',
            'SSN' => 'required|string',
            'phone' => 'required|string|between:2,100',
            'address' => 'required|string',
            'department_id' => 'required|in:1,2,3,4',
            'gender' => 'required|string',
            'marital_status' => 'required|string',
            'idea' => 'string',
            'email' => 'required|string|email|max:100|unique:students', // Ensure email uniqueness in the 'students' table
            'type' => 'required|in:' . implode(',', Student::type), // Validate 'type' field against predefined options in the Student model
            'password' => '|string|confirmed|min:6', // Validate password confirmation and length
        ]);

        // If validation fails, return errors
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        // Create a new user record in the 'students' table
        $user = Student::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)] // Hash the password before storing
        )); 

        //noti
        
        // Return a success response with the created user details
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Log out the authenticated user (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout(); // Log out the authenticated user
        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a JSON Web Token (JWT).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh()); // Refresh the token and return a new JWT
    }

    /**
     * Get the authenticated User profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user()); // Return the authenticated user's profile data
    }

    /**
     * Create a new JWT response.
     *
     * @param  string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard("student")->factory()->getTTL() * 60,
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
    if($validator->fails()){
        return response()->json($validator->errors()->toJson(), 400);
    }

    // الحصول على الطالب المصادق عليه
    $student = auth()->user();

    // ربط المقررات المطلوبة بالطالب
    $student->courses()->sync($request->course_ids);

    return response()->json([
       'message' => 'Courses successfully enrolled',
       'user' => $student
    ], 201);
} 

public function showgrade()
    { 
        $id = auth()->user()->id  ;
        $department = CourseStudent::where('student_id', $id)->first();
        return response()->json($department);
    }
public function showcourses()
    { 
        $id = auth()->user()->id  ;
        $department = CourseStudent::where('student_id', $id)->first();
        return response()->json($department);
    }
public function showreports()
    { 
        $id = auth()->user()->id  ; 
        $report = Report::get();
       
        return response()->json($report);
    }
    public function showreport()
    {
        $student = auth()->user(); // Get the authenticated user (student)
        
        // Check if the student belongs to any department
        if ($student->department) {
            $head_id = $student->department->head_id;
    
            // Find the report for the student with the specified head_id
            $report = Report::where('student_id', $student->id)
                           
                            ->first();
    
            if ($report) {
                return response()->json($report);
            } else {
                return response()->json(['message' => 'Report not found.'], 404);
            }
        } else {
            return response()->json(['message' => 'Student does not belong to any department.'], 404);
        }
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

}
