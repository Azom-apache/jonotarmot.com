<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
  

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'role',
        'gender',
        'age',
        'country',
        'city',
        'language',
        'profile_pic',
        'phone',
        'payment_method',
        'is_subscribed',
        'start_date',
        'end_date',
        'latitude',
        'longitude',
        'otp',
        'call_status',
        'is_online',
        'is_active',
        'professional_situation',
        'occupation',
        'education_level',
        'music_genre',
        'film_series_preference',
        'artistic_activities',
        'sports',
        'relationship_status',
        'children',
        'number_of_children',
        'religious_affiliation',
        'about_me',
        'religion_name',
        'address',
        'postal_code',
    ];
    public function country()
    {
        return $this->belongsTo(Country::class, 'country');
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language');
    }
    public function randomOnlineUser($loggedInUserId)
    {
        $onlineUsers = User::where('is_online', 1)
                       ->where('is_active', 1)
                       ->where('id', '!=', $loggedInUserId) // Exclude the logged-in user
                       ->inRandomOrder()
                       ->limit(6)
                       ->get();

        if($onlineUsers->isEmpty()) {
            return collect();
        }
    
        return $onlineUsers;
    }
    // Friend.php
public function friend()
{
    return $this->belongsTo(User::class, 'friend_id');
}

public function initiatedChats()
{
    return $this->hasMany(Chat::class, 'caller_id', 'id');
}

public function receivedChats()
{
    return $this->hasMany(Chat::class, 'receiver_id', 'id');
}
}
