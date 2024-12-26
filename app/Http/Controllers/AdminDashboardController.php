<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Slider;
use App\Models\Translation;
use App\Models\PollQuestion;
use App\Models\PollOption;
class AdminDashboardController extends Controller
{
    // public function index (){
    //     $admin = auth()->user();
    //     $user = $admin->user;
    //     $polls = PollQuestion::all();
    //     return view('dashboard', compact('user','polls'));
    // }

    public function Adminbranches (){
        $admin = auth()->user();
        $user = $admin->user;
        $plans = Plan::all();
        return view('/admin/branches', compact('user', 'plans'));
    }
    public function addPlans (){
        $admin = auth()->user();
        $user = $admin->user;
        $plans = Plan::all();
        return view('/admin/add-plans', compact('user', 'plans'));
    }
    public function addSub (Request $request){
        $admin = auth()->user();
        $user = $admin->user;
        
        $request->validate([
            'name'=>'string|required',
            'duration'=>'string|required',
            'amount'=>'string|required',
            'ads_times'=>'string|required',
            'details'=>'string|required',
        ]);

        $plans = new Plan();
        $plans->name =  $request->input('name');
        $plans->duration =  $request->input('duration');
        $plans->amount =  $request->input('amount');
        $plans->details =  $request->input('details');
        $plans->ads_times =  $request->input('ads_times');
        

        $plans->save();

        return view('/admin/add-plans', compact('user', 'plans'));
    }
    public function sliders (){
        $admin = auth()->user();
        $user = $admin->user;
        $slider = Slider::all();
        return view('/admin/sliders', compact('user', 'slider'));
    }
    public function addBanner(Request $request)
{
    $admin = auth()->user();
    $user = $admin->user;
    
    $request->validate([
        'banner_name' => 'string|required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $sliders = new Slider();

    $sliders->banner_name = $request->input('banner_name');

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move('images/apps', $imageName);
       
        $sliders->image = $imageName;
    }

    $sliders->save();

    return view('/admin/sliders', compact('user', 'sliders'));
}

public function editPlan($id)
{
    $admin = auth()->user();
    $user = $admin->user;
    $plan = Plan::findOrFail($id);
    
    return view('admin/edit-plan', compact('user', 'plan'));
}
public function updatePlans(Request $request)
{

    $request->validate([ 
        'plan_id' => 'required|string',
        'name' => 'required|string',
        'duration' => 'required|string',
        'amount' => 'required|string',
        'ads_times' => 'required|string',
        'details' => 'required|string',
    ]);
    $id = $request->input('plan_id');
    $plan = Plan::findOrFail($id);
    // Update the plan with the new data
    $plan->update([
        'name' => $request->input('name'),
        'duration' => $request->input('duration'),
        'amount' => $request->input('amount'),
        'ads_times' => $request->input('ads_times'),
        'details' => $request->input('details'),
    ]);
    
    return redirect()->route('editPlan', $id)->with('success', 'Plan updated successfully');

}
public function removePlan($id)
{
    // Find the plan by its ID
    $plan = Plan::findOrFail($id);
    
    // Delete the plan
    $plan->delete();
    
    // Redirect back to the plans page
    return redirect()->route('plans')->with('success', 'Plan removed successfully');
}

public function trnaslationView(){
    $admin = auth()->user();
    $user = $admin->user;
    $trans = Translation::all();
    return view('/admin/translations', compact('user', 'trans'));
}
public function addTranslation (){
    $admin = auth()->user();
    $user = $admin->user;

    return view('/admin/add-translation', compact('user'));
}
public function saveTranslations(Request $request){
    $admin = auth()->user();
    $user = $admin->user;

    $key_text = $request->input('key_text');
        $translations = [];

        for ($i = 0; $i < count($request->input('translate')); $i++) {
            $translations[] = [
                'key_text' => $key_text,
                'translate' => $request->input('translate')[$i],
                'lang' => $request->input('lang')[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Translation::insert($translations);

        return redirect()->back()->with('success', 'Translations saved successfully.');
}
}
