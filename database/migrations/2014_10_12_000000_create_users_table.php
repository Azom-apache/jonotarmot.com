<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('role')->default('user');
            $table->string('gender');
            $table->string('age');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('language')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('phone')->nullable();
            $table->string('professional_situation')->nullable();
            $table->string('occupation')->nullable();
            $table->string('education_level')->nullable();
            $table->string('music_genre')->nullable();
            $table->string('film_series_preference')->nullable();
            $table->string('artistic_activities')->nullable();
            $table->string('sports')->nullable();
            $table->string('relationship_status')->nullable();
            $table->string('children')->nullable();
            $table->string('number_of_children')->nullable();
            $table->string('about_me')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('adds_points')->nullable();
            $table->string('is_subscribed')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('otp');
            $table->string('call_status')->default(0);
            $table->string('is_online')->default(1);
            $table->string('is_active')->default(0);
            $table->string('token')->default(0);
            $table->string('status')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
