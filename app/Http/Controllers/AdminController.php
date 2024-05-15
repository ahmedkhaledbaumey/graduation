<?php
namespace App\Http\Controllers;

use Validator;
use App\Models\Report;
use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\CourseStudent;
use App\Models\Prof;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{ 
    public function loginstudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    
        return $this->createNewToken($token);
    }

    public function register(Request $request)
    {
        // Validate the request parameters for user registration
        $validator = Validator::make($request->all(), [
        
            'email' => 'required|string|email|max:100|unique:students,email', // Ensure email uniqueness in the 'students' table
            'password' => 'required|string|confirmed|min:6', // Validate password confirmation and length
        ]);
    
        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
    
        // Process enrollment papers (multiple file uploads)
     
    
        // Create a new user record in the 'students' table
        $user = Student::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)], // Hash the password before storing
          
        ));
    
        // Send notification or perform other actions here...
    
        // Return a success response with the created user details
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    } 


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
            'login_type' => auth()->user()->login_type, // Assuming 'login_type' is an attribute of the user model

            // 'user' => auth()->user() // Return the authenticated user's data in the response
        ]);
    } 

} 
