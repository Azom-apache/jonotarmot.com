<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chat;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
    }

    public function getAdsTimes(){
        
        $admin = auth()->user();
        $user = $admin->user;
        $chatWithPlan = Chat::where(function ($query) use ($user) {
                $query->where('caller_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->whereIn('status', ['pending', 'active'])
            ->with(['caller', 'receiver']) // Load caller and receiver relationships
            ->first();
            
        if ($chatWithPlan) {
            $activeSubscription = Subscription::where('user_id', $user->id)
                ->where('status', '1')
                ->first();
                
            if ($activeSubscription) {
                $plan = Plan::find($activeSubscription->plan_id);
                $time = $plan->ads_times;
                $adsTimes = $plan ? $plan->ads_times : null;
                return response()->json(['ads_times' => $adsTimes]);
            } else {
                return response()->json(['error' => 'No active subscription'], 404);
            }
        } else {
            
        }
    }
    

}
