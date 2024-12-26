<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
class AdminAuthController extends Controller
{
    public function showRegistrationForm()
    {
        $countries = getCountries();
        $languages = getLanguages();
        return view('/register', compact('countries', 'languages'));
    }
    public function register()
    {
        $countries = getCountries();
        $languages = getLanguages();
        return view('/register', compact('countries', 'languages'));
    }
    public function userRegister(Request $request){
        $request->validate([
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'string|required|email|unique:users,email',
            'password' => 'string|required|min:8',
            'country' => 'string|required',
            'language' => 'string|required',
            'age' => 'string|required',
            // Add more validation rules as needed
        ]);
        $username = $this->generateUniqueUsername($request->input('first_name'));
        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name'); 
        $user->gender = $request->input('gender');
        $user->email = $request->input('email');
        $user->username =$username;
        $user->country = $request->input('country');
        $user->language = $request->input('language');
        $user->age = date('Y-m-d', strtotime($request->input('age')));
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->save();

        $user_id = $user->id;
        $admin = new Admin();
        $admin->user_id =$user_id;
        $admin->email = $request->input('email');
        $admin->password = Hash::make($request->input('password'));
        $admin->role ='user';
        $admin->save();
        Mail::to($user->email)->send(new OtpMail($otp));
       
        if ($user->id) {
            session(['user_id' => $user->id, 'otp' => $otp]); 
            return view('verify-otp');
        } else {
            return back()->withInput()->withErrors(['registration_failed' => 'Failed to register user']);
        }
    }
    public function otpVerification(Request $request){
        $user_id = session('user_id');
        $request->validate([
            'otp'=>'string|required',
        ]);
        $user = User::find($user_id);
        if(!$user){
            return back()->withErrors(['user_not_found' => 'User not found']);
        }
        if ($user->otp === $request->otp) {
            $user->is_active = true;
            $user->save();
            $admin = Admin::where('user_id', $user_id)->first();
        
            if ($admin) {
                // Update is_verified field in the admins table
                $admin->is_verified = 1;
                $admin->save();
            }
            return redirect('/login');
        } else {
            return view('verify-otp')->with(['otp_mismatch' => 'Invalid OTP']);
        }
    }
    
    
    public function showLoginForm()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'user') {
                return redirect()->route('dashboard');
            } elseif ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }
        return view('/login');
    }
    public function login(Request $request)
        {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                if ($user->is_verified == 1) {
                    $role = $user->role;
                    if ($role === 'user') {
                        return redirect()->route('dashboard');
                    } elseif ($role === 'admin') {
                        return redirect()->route('admin.dashboard');
                    }
                } else {
                    Auth::logout();
                    return back()->withInput()->withErrors(['email' => 'User is not verified']);
                }
            }

            return back()->withInput()->withErrors(['email' => 'Invalid credentials']);
        }

        private function generateUniqueUsername($firstName) {
            $username = strtolower($firstName . '_' . Str::random(5)); // Example: first name followed by a random string of length 5
        
            while (User::where('username', $username)->exists()) {
                $username = strtolower($firstName . '_' . Str::random(5)); // Regenerate username if it already exists
            }
        
            return $username;
        }
        
        
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

