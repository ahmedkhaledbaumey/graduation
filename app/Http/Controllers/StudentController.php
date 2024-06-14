<?php
namespace App\Http\Controllers;

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

class StudentController extends Controller
{
    /**
     * Create a new instance of StudentController.
     *
     * @return void
     */
    public function __construct() {
        // Apply middleware to protect routes, except for login and register
        // $this->middleware('auth:student', ['except' => ['login', 'register' ,'makereporthead','makereportprof']]);
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
    public function loginstudent(Request $request){
        $validator = Validator::make($request->all(), [
            'account' => 'required|email',
            'SSN' => 'required|string|min:6',
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
   
public function register(Request $request)
{
    // Validate the request parameters for user registration
    $validator = Validator::make($request->all(), [
        'enrollment_papers.*' => 'required|image|mimes:png,jpg,jpeg|max:2048', // Validating multiple image uploads
        'original_bachelors_degree' => 'required|image|mimes:png,jpg,jpeg|max:2048', // Validating the original bachelor's degree
        'name' => 'required|string|between:2,100',
        'english_name' => 'required|string|between:2,100',
        'nationality' => 'required|string|between:2,100',
        'religion' => 'required|string|between:2,100',
        'job' => 'required|string|between:2,100',
        'age' => 'required|integer', // Assuming age is an integer
        'SSN' => 'required|string|between:2,100|unique:students,SSN', // Ensure SSN uniqueness in the 'students' table
        'phone' => 'required|string|between:2,100',
        'address' => 'required|string',
        'department_id' => 'required|in:1,2,3,4',
        'gender' => 'required|string', // Validating against specific genders
        'marital_status' => 'required|string', // Validating against specific marital statuses
        'idea' => 'nullable|string', // Assuming idea is optional
        'email' => 'required|string|email|max:100|unique:students,email', // Ensure email uniqueness in the 'students' table
        'type' => 'required|in:' . implode(',', Student::type), // Validate 'type' field against predefined options in the Student model
    ]);

    // If validation fails, return errors
    if ($validator->fails()) {
        return response()->json($validator->errors()->toJson(), 400);
    }

    // Process enrollment papers (multiple file uploads)
    $enrollmentPapers = [];
    if ($request->hasFile('enrollment_papers')) {
        foreach ($request->file('enrollment_papers') as $file) {
            $path = $file->store('student/enrollment_papers'); // Store each file in a directory
            $enrollmentPapers[] = $path;
        }
    }

    // Process original bachelor's degree (single file upload)
    $originalBachelorsDegree = null;
    if ($request->hasFile('original_bachelors_degree')) {
        $originalBachelorsDegree = $request->file('original_bachelors_degree')->store('student/original_bachelors_degree');
    }

    // Create a new student record in the 'students' table
    $student = Student::create(array_merge(
        $validator->validated(),
        ['password' => bcrypt($request->password)]
    ));

    // Create a new student_photos record in the 'student_photos' table
    $studentPhotos = new StudentPhotos([
        'student_id' => $student->id,
        'enrollment_papers' => json_encode($enrollmentPapers), // Store uploaded files' paths as JSON
        'original_bachelors_degree' => $originalBachelorsDegree, // Store the uploaded file's path
    ]);
    $studentPhotos->save();

    // Return a success response with the created student details
    return response()->json([
        'message' => 'User successfully registered',
        'student' => $student,
        'student_photos' => $studentPhotos
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
        $department[] = CourseStudent::where('student_id', $id)->get(); 

        return response()->json($department);
    }
public function showreports()
    { 
        $id = auth()->user()->id  ; 
        $report = Report::get();
       
        return response()->json($report);
    } 
     
    public function showreportsstudent()
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
    public function showreportsprof()
    {
        $prof = auth()->user(); // Get the authenticated user (prof)
        
        // Check if the student belongs to any department
        if ($prof->department) {
            // $head_id = $prof->department->head_id;
    
            // Find the report for the student with the specified head_id
            $report = Report::where('prof_id', $prof->id)
                           
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
    public function showreportshead()
    {
        $head = auth()->user(); // Get the authenticated user (head)
        
        // Check if the student belongs to any department
        // if ($head->department) {
        //     $head_id = $head->department->head_id;
    
            // Find the report for the student with the specified head_id
            $report = Report::where('head_id', $head->id)
                           
                            ->first();
    
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
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        // Get the authenticated student 
        $student_id = auth()->user()->id;
        $student = Student::find($student_id);
        $head_id = $student->department->head_id ; 
    
        // Create a new Report instance with validated data
        $report = new Report([
            'content' => $request->input('content'),
            'type' => $request->input('type'),
            'date' => $request->input('date'),
            // 'prof_id' => $request->input('prof_id'),
            'head_id' => $head_id,
            'student_id' => $student->id,
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
    public function addresearchplan($researchPlan)
    {
        // Get the authenticated user (student)
        $head = request()->user()->id; 
        $department = Department::where('head_id', $head); 
        $department->research_plan = $researchPlan;

        // Check if the student belongs to any department
      
            return response()->json([
                'message' => 'addResearch success',
            ], 404);
    } 
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
  


