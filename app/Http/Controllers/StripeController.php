<?php
namespace App\Http\Controllers;

use Exception;
use App\Models\Department;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function makePayment(Request $request)
    {
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $res = $stripe->tokens->create([
                'card' => [
                    'number' => $request->number,
                    'exp_month' => $request->exp_month,
                    'exp_year' => $request->exp_year,
                    'cvc' => $request->cvc,
                ],
            ]);

            $response = $stripe->charges->create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'source' => $res->id,
                'description' => $request->description,
            ]);

            return response()->json($response, 200);

        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    } 





    public function addplan(Request $request, $id)
    {
        // Validate request data
        $validatedData = $request->validate([
            'research_plan' => 'string|nullable',
        ]);
    
        // Ensure research_plan key exists in validated data
        if (!array_key_exists('research_plan', $validatedData)) {
            return response()->json(['error' => 'Invalid request. Missing research_plan field.'], 400);
        }
    
        $department = Department::findOrFail($id);
        $department->research_plan = $validatedData['research_plan'];
        $department->save();
    
        return response()->json(['message' => 'Research Plan Added Successfully.', 'department' => $department], 201);
    }
    
}
