<?php
namespace App\Http\Controllers;

use Validator;
use App\Models\Report;
use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\CourseStudent;
use App\Models\Employee;
use App\Models\Head;
use App\Models\Prof;
use App\Models\ViceDean;
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
    public function loginhead(Request $request ,$guard)
    {
        $validator = Validator::make($request->all(), [
            'account' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        if (! $token = auth()->guard($guard)->attempt($validator->validated())) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    
        return $this->createNewToken($token);
    }
    // public function loginemployee(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'account' => 'required|email',
    //         'password' => 'required|string|min:6',
    //     ]);
    
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }
    
    //     if (! $token = auth()->guard('employee')->attempt($validator->validated())) {
    //         return response()->json(['error' => 'Invalid credentials'], 401);
    //     }
    
    //     return $this->createNewToken($token);
    // }
    // public function loginvice(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'account' => 'required|email',
    //         'password' => 'required|string|min:6',
    //     ]);
    
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }
    
    //     if (! $token = auth()->guard('vice_dean')->attempt($validator->validated())) {
    //         return response()->json(['error' => 'Invalid credentials'], 401);
    //     }
    
    //     return $this->createNewToken($token);
    // }
    // public function loginprof(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'account' => 'required|email',
    //         'password' => 'required|string|min:6',
    //     ]);
    
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }
    
    //     if (! $token = auth()->guard('prof')->attempt($validator->validated())) {
    //         return response()->json(['error' => 'Invalid credentials'], 401);
    //     }
    
    //     return $this->createNewToken($token);
    // }

    public function addhead(Request $request)
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
        $user = Head::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password) , 
            'name' => $request->name , 
            'email' => $request->email 

        ], // Hash the password before storing
          
        ));
    
        // Send notification or perform other actions here...
    
        // Return a success response with the created user details
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    } 
    public function addprof(Request $request)
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
        $user = Prof::create(array_merge(
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
    public function addemployee(Request $request)
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
        $user = Employee::create(array_merge(
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
    public function addvice(Request $request)
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
        $user = ViceDean::create(array_merge(
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
    public function userProfile($guard) {
        return response()->json(auth()->guard($guard)->user()); // Return the authenticated user's profile data
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
            'expires_in' => auth()->guard("student")->factory()->getTTL() * 60000,
            'login_type' => auth()->user()->login_type, // Assuming 'login_type' is an attribute of the user model

            // 'user' => auth()->user() // Return the authenticated user's data in the response
        ]);
    } 


    public function updateAccountprof(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'email' => 'required|email|unique:students,email,' . Auth::user()->id,
            'name' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:6', // Validate password confirmation and length
        ]);

        // Retrieve the user from the database
        $user = Prof::where('email', $validated['email'])->first();

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
    public function updateAccountemployee(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'email' => 'required|email|unique:students,email,' . Auth::user()->id,
            'name' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:6', // Validate password confirmation and length
        ]);

        // Retrieve the user from the database
        $user = Employee::where('email', $validated['email'])->first();

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
    public function updateAccounthead(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'email' => 'required|email|unique:students,email,' . Auth::user()->id,
            'name' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:6', // Validate password confirmation and length
        ]);

        // Retrieve the user from the database
        $user = Head::where('email', $validated['email'])->first();

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
    public function updateAccountvice(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'email' => 'required|email|unique:students,email,' . Auth::user()->id,
            'name' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:6', // Validate password confirmation and length
        ]);

        // Retrieve the user from the database
        $user = ViceDean::where('email', $validated['email'])->first();

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

    public function deletehead($id)
    {
        $head = Head::find($id);
        $head->delete();
        return response()->json([
            'message' => "head Delete Successfully!"
        ], 200);
    }
    public function deleteprof($id)
    {
        $prof = Prof::find($id);
        $prof->delete();
        return response()->json([
            'message' => "prof Delete Successfully!"
        ], 200);
    }
    public function deleteemployee($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        return response()->json([
            'message' => "prof Delete Successfully!"
        ], 200);
    }
    public function deletevice($id)
    {
        $vice = ViceDean::find($id);
        $vice->delete();
        return response()->json([
            'message' => "prof Delete Successfully!"
        ], 200);
    }

} 
