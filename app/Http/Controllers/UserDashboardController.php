<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Country;
use App\Models\Language;
use App\Models\PollQuestion;
use App\Models\PollOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class UserDashboardController extends Controller
{

    public function index()
    {
        // Get the authenticated user
        $admin = auth()->user();
        $user = $admin->user;
        
        // Fetch the polls that belong to this user
        $polls = PollQuestion::where('user_id', $user->id)->get(); // Don't forget ->get()
        
        return view('dashboard', compact('user', 'polls'));
    }
    


    
    public function userProfile(){
        $admin = auth()->user();
        $user = $admin->user;
        $country = Country::find($user->country);
        $language = Language::find($user->language);
        $countryName = $country ? $country->name : null;
        $languageName = $language ? $language->name : null;
        $countries = Country::all();
        return view('profile', [
            'user' => $user,
            'countryName' => $countryName,
            'languageName' => $languageName,
            'countries' => $countries, 
        ]);
    }
    
    

    public function updateProfile(Request $request)
    {
        $admin = auth()->user();
        $user = $admin->user;
    
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'country' => 'required|array',
            'city'  =>'nullable|string',
            'language' => 'required|array',
            'phone' => 'nullable|string',
            'age' => 'required|string',
            'professional_situation' => 'nullable|string',
            'occupation' => 'nullable|string',
            'education_level' => 'nullable|string',
            'music_genre' => 'nullable|string',
            'film_series_preference' => 'nullable|string',
            'artistic_activities' => 'nullable|string',
            'sports' => 'nullable|string',
            'relationship_status' => 'nullable|string', 
            'children' => 'nullable|string',
            'number_of_children' => 'nullable|string',
            'religious_affiliation' => 'nullable|string',
            'about_me' => 'nullable|string',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'religion_name' => 'nullable|string',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string',
        ]);
        // dd($request->input('about_me'));
        $selectedCountries = $request->input('country');
        $countryString = implode(',', $selectedCountries);
        $selectedLanguages = $request->input('language');
        $languageString = implode(',', $selectedLanguages);
        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'gender' => $request->input('gender'),
            'age' => \Carbon\Carbon::createFromFormat('d.m.Y', $request->input('age'))->format('Y-m-d'),
            'country' => $countryString,
            'city' => $request->input('city'),
            'language' => $languageString ,
            'phone' => $request->input('phone'),
            'professional_situation'=>$request->input('professional_situation'),
            'occupation'=>$request->input('occupation'),
            'education_level'=>$request->input('education_level'),
            'music_genre'=>$request->input('music_genre'),
            'film_series_preference'=>$request->input('film_series_preference'),
            'artistic_activities'=>$request->input('artistic_activities'),
            'sports'=>$request->input('sports'),
            'relationship_status'=>$request->input('relationship_status'),
            'children'=>$request->input('children'),
            'number_of_children'=>$request->input('number_of_children'),
            'religious_affiliation'=>$request->input('religious_affiliation'),
            'about_me'=>$request->input('about_me'),
            'religion_name'=>$request->input('religion_name'),
            'address'=>$request->input('address'),
            'postal_code'=>$request->input('postal_code')
        ]);
  
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    
    public function updateLanguage(Request $request)
    {  
        $admin = auth()->user();
        $user = $admin->user;
        $request->validate([
            'language_id' => 'required|exists:languages,id',
        ]);
        $user->language = $request->input('language_id');
        $user->save();
    }

    public function updateOnlineStatus(Request $request)
    {  
    $admin = auth()->user();
    $user = $admin->user;
    $request->validate([
        'is_online' => 'required|boolean',
    ]);
    $user->is_online = $request->input('is_online');
    $user->save();
    }

    
    public function showVideoCallingView()
    {
        $admin = auth()->user();
        $user = $admin->user;
    
        return view('video-calling', ['user' => $user]);
    }
    public function uploadProfilePic(Request $request) {
        $admin = auth()->user();
        $user = $admin->user;
        $request->validate([
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('images/users', $imageName);
    
            // Update the profile_pic field in the users table
            $user->update(['profile_pic' => $imageName]);
    
            return response()->json([
                'success' => true,
                'profile_pic_url' => asset('images/users/' . $imageName),
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'No file uploaded.',
        ]);
    }
    public function searchByUsername(Request $request)
    {
        $query = $request->input('username');
        $users = User::where('username', 'like', '%' . $query . '%')->get();
        
        $users = $users->map(function($user) {
            $user->encrypted_id = encrypt($user->id);
            return $user;
        });
    
        return response()->json(['users' => $users]);
    }
    

    
}
