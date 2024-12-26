<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $admin = auth()->user();
        $user = $admin->user;
        $plans = Plan::where('duration', 'monthly')->get();
    
        return view('plans', compact('user', 'plans'));
    }
    
    public function filterPlans(Request $request)
    {
        $duration = $request->input('duration');
        $plans = Plan::where('duration', $duration)->get();
    
        // Translate the plans data
        $translatedPlans = $plans->map(function($plan) {
            $plan->name = translate($plan->name);
            if ($plan->details) {
                $plan->details = collect(explode('•', $plan->details))
                    ->map(function($detail) {
                        return translate(trim($detail));
                    })->implode('•');
            }
            return $plan;
        });
    
        return response()->json($translatedPlans);
    }
    
    public function subscribe(Request $request){

        $request->validate([
            'plan_id' => 'required', 
            'payment_method' => 'required', 
        ]);
        $plan_id = $request->input('plan_id');
        $payment = $request->input('payment_method');
        $plans = Plan::where('id',$plan_id)->first();
        
        $admin = auth()->user();
        $user = $admin->user;
        $duration = $plans->duration; // Assuming the duration is stored in a variable
        if($duration=="Monthly"){
            $endDate = date('Y-m-d', strtotime("+30 days"));
        }elseif($duration=="Yearly"){
            $endDate = date('Y-m-d', strtotime("+365 days"));
        }
       
        if($plans){
            $subscribe = new Subscription();
            $subscribe->user_id = $user->id;
            $subscribe->plan_id = $plan_id;
            $subscribe->end_date = $endDate;
            $subscribe->status = 1;

            $subscribe->save();
            $user->payment_method = $payment;
            $user->is_subscribed = 1;
            $user->end_date = $endDate;
            $user->save();
            return redirect()->route('dashboard');
        }else{
            return back()->withErrors(['subscription_error' => 'Subscription process failed. Please try again.']);
        }
    }


}
