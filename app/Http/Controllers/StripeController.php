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
            'research_plan' => 'nullable|file|mimes:pdf,doc,docx,png|max:2048', // قبول ملفات pdf و doc و docx بحجم أقصى 2 ميجا
        ]);
    
        // الحصول على القسم المعين
        $department = Department::findOrFail($id);
    
        // تحقق مما إذا كان هناك ملف محمل
        if ($request->hasFile('research_plan')) {
            // حفظ الملف في مجلد محدد
            $filePath = $request->file('research_plan')->store('research_plans', 'public');
            // تحديث مسار البحث في قاعدة البيانات
            $department->research_plan = $filePath;
        } else {
            return response()->json(['error' => 'Invalid request. Missing research_plan file.'], 400);
        }
    
        // حفظ التغييرات في القسم
        $department->save();
    
        return response()->json(['message' => 'Research Plan Added Successfully.', 'department' => $department], 201);
    }
    
    
}
