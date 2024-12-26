<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OtpMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('register');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        $username = $request->input('first_name');
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
        $otp = 1234;
        $user->otp = $otp;
        $user->save();

        $user_id = $user->id;
        $admin = new Admin();
        $admin->user_id =$user_id;
        $admin->email = $request->input('email');
        $admin->password = Hash::make($request->input('password'));
        $admin->role ='user';
        $admin->save();
      //  Mail::to($user->email)->send(new OtpMail($otp));
       
        if ($user->id) {
            session(['user_id' => $user->id, 'otp' => $otp]); 
            return view('verify-otp');
        } else {
            return back()->withInput()->withErrors(['registration_failed' => 'Failed to register user']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
