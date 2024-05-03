<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use Validator;

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
            'age' => 'required|string|between:2,100',
            'SSN' => 'required|string|between:2,100',
            'phone' => 'required|string|between:2,100',
            'address' => 'required|string',
            'department_id' => 'required|in:1,2,3,4',
            'gender' => 'required|in:female,male',
            'marital_status' => 'required|in:married,divorce,other',
            'idea' => 'required|string',
            'email' => 'required|string|email|max:100|unique:students', // Ensure email uniqueness in the 'students' table
            'type' => 'required|in:' . implode(',', Student::type), // Validate 'type' field against predefined options in the Student model
            'password' => 'required|string|confirmed|min:6', // Validate password confirmation and length
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

}
