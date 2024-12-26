<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    public function run()
    {
        // Retrieve users from the users table
        $users = DB::table('users')->get();

        // Insert each user into the admins table with email and password
        foreach ($users as $user) {
            DB::table('admins')->insert([
                'user_id' => $user->id,
                'email' => $user->email,
                'password' => Hash::make('password'), // Default password
                'role' => $user->role, // Map the user's role from the users table
                'is_verified' => 1, // Default verification status
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
    }
}
