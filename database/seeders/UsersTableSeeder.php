<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'role' => 'user',
                'gender' => 'male',
                'age' => '25',
                'country' => 'USA',
                'city' => 'New York',
                'language' => 'English',
                'profile_pic' => 'default.jpg',
                'phone' => '123456789',
                'payment_method' => 'paypal',
                'is_subscribed' => 1,
                'start_date' => now(),
                'end_date' => now()->addMonths(6), // Example: 6 months from now
                'latitude' => '40.7128',
                'longitude' => '-74.0060',
                'otp' => '1234', // Assuming this is a verification code
                'call_status' => 0,
                'is_online' => 1,
                'is_active' => 1, // Set to 1 for active user
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'email' => 'jane@example.com',
                'role' => 'user',
                'gender' => 'female',
                'age' => '25',
                'country' => 'Canada',
                'city' => 'Toronto',
                'language' => 'English',
                'profile_pic' => 'default.jpg',
                'phone' => '987654321',
                'payment_method' => 'credit_card',
                'is_subscribed' => 0,
                'start_date' => now(),
                'end_date' => null, // Example: No end date specified
                'latitude' => '43.65107',
                'longitude' => '-79.347015',
                'otp' => '5678', // Assuming this is a verification code
                'call_status' => 1,
                'is_online' => 0,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
