<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Friend; 
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

class FriendController extends Controller
{
    // protected $admin;
    // protected $user;

    // public function __construct()
    // {
    //     $this->admin = Auth::user();
    //     $this->user = $this->admin->user;
    // }
    public function searchByUsername(Request $request)
        {
            // Validate the request input
            $request->validate([
                'username' => 'nullable|string',
            ]);
            $username = $request->input('username');

            $searchedUser = User::where('username', $username)
                ->where('is_online', 1)
                ->where('is_active', 1)
                ->where('id', '!=', $this->$this->user->id)
                ->first();

            if ($searchedUser) {
                // $friendStatus = Friend::where(function ($query) use ($user, $searchedUser) {
                //     $query->where('user_id', $user->id)
                //         ->where('friend_id', $searchedUser->id);
                // })->orWhere(function ($query) use ($user, $searchedUser) {
                //     $query->where('user_id', $searchedUser->id)
                //         ->where('friend_id', $user->id);
                // })->where('friend_status', '!=', 'blocked')
                // ->first();
                return response()->json(['user' => $searchedUser]);
                // if (!$friendStatus) {
                //     return response()->json(['user' => $searchedUser]);
                // } else {
                //     return response()->json(['message' => 'User found but blocked.']);
                // }
            }
            
            return response()->json(['message' => 'User not found or inactive.']);
        }

            public function friendsList()
            {
                $admin = auth()->user();
                $user = $admin->user;
                $friendships = Friend::where('friend_status', 'friends')
                    ->where(function ($query) use ($user) {
                        $query->where('user_id', $user->id)
                              ->orWhere('friend_id', $user->id);
                    })
                    ->get();
            
                $allFriends = [];
                foreach ($friendships as $friendship) {
                    $friendId = $friendship->user_id == $user->id ? $friendship->friend_id : $friendship->user_id;
                    $friend = User::find($friendId);
                    if ($friend) {
                        $countryName = Country::find($friend->country)->name ?? null;
                        $allFriends[] = [
                            'friend' => $friend,
                            'country_name' => $countryName,
                        ];
                    }
                }
            
                return view('friends-lists', compact('user', 'allFriends'));
            }
            
            

        public function blockUsers($encryptedUserId){
            $admin = auth()->user();
            $user = $admin->user;
            $friendId = decrypt($encryptedUserId);
            $isFriend = $this->isUserFriend($user->id, $friendId);

            if($isFriend== true){
                Friend::where(function ($query) use ($user, $friendId) {
                    $query->where('user_id', $user->id)
                          ->where('friend_id', $friendId);
                })->orWhere(function ($query) use ($user, $friendId) {
                    $query->where('user_id', $friendId)
                          ->where('friend_id', $user->id);
                })->update(['friend_status' => 'blocked', 'blocked_by'=>$user->id]);
            }else{
                $addFriends = new Friend();
                $addFriends->user_id = $user->id;
                $addFriends->friend_id = $friendId;
                $addFriends->friend_status	 ="blocked";
                $addFriends->blocked_by	 =$user->id;
                $addFriends->save();

            }
            return Redirect::route('block-lists');

        }

        public function unBlock($encryptedId, $encryptedStatus)
        {
            try {
                $admin = auth()->user();
                $user = $admin->user;
        
                $friendId = decrypt($encryptedId);
                $status = decrypt($encryptedStatus);
                // dd($status);
                if (!$friendId) {
                    throw new \Exception("Failed to decrypt ID");
                }
        
                $friend = Friend::where(function ($query) use ($user, $friendId) {
                    $query->where('user_id', $user->id)
                          ->where('friend_id', $friendId);
                })->orWhere(function ($query) use ($user, $friendId) {
                    $query->where('user_id', $friendId)
                          ->where('friend_id', $user->id);
                })->first();

                if (!$friend) {
                    throw new \Exception("Friend not found");
                }
        
                if ($status == 'unblock') {
                    $friend->friend_status = 'friends';
                    $friend->blocked_by = Null;
                } elseif ($status == 'blocked') {
                    $friend->friend_status = 'blocked';
                    $friend->friend_type ='normal';
                    $friend->blocked_by = $user->id;
                } elseif ($status == "accepted") {
                    $friend->friend_status = 'friends';
                }elseif($status == "bestfriend"){
                    $friend->friend_type = 'best';
                }
                 elseif ($status == "cancelled") {
                    $friend->delete();
                    return redirect()->back()->with('success', 'Friend record deleted successfully');
                }
                $friend->save();
        
                return redirect()->back()->with('success', 'Friend unblocked successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to unblock friend: ' . $e->getMessage());
            }
        }
        
        public function addFriends($encryptedUserId){
            $admin = auth()->user();
            $user = $admin->user;
            $friendId = decrypt($encryptedUserId);

            $isFriend = $this->isUserFriend($user->id, $friendId);
            if($isFriend== false){
                $addFriends = new Friend();
                $addFriends->user_id = $user->id;
                $addFriends->friend_id = $friendId;
                $addFriends->friend_status	 ="pending";
                $addFriends->save();
                return redirect()->back()->with('success', 'Friend Request sent');
            }else{
            }
            
        }
        public function isUserFriend($loggedInUserId, $chatUserId) {
            $friendship = Friend::where(function($query) use ($loggedInUserId, $chatUserId) {
                                $query->where('user_id', $loggedInUserId)
                                      ->where('friend_id', $chatUserId);
                            })
                            ->orWhere(function ($query) use ($loggedInUserId, $chatUserId) {
                                $query->where('user_id', $chatUserId)
                                      ->where('friend_id', $loggedInUserId);
                            })
                            ->first();
            return $friendship !== null;
        }
        public function pendingList()
        {
            $admin = auth()->user();
            $user = $admin->user;
            $friendships = Friend::where('friend_status', 'pending')
                ->where('friend_id', $user->id)
                ->get();
        
            $pendingFriends = [];
            foreach ($friendships as $friendship) {
                $friendId = $friendship->user_id;
                $friend = User::find($friendId);
                if ($friend) {
                    $countryName = Country::find($friend->country)->name ?? null;
                    $pendingFriends[] = [
                        'id' => encrypt($friend->id),
                        'friend' => $friend,
                        'country_name' => $countryName,
                    ];
                }
            }
        
            return response()->json(['pendingFriends' => $pendingFriends]);
        }
        
        
            public function myFriendList()
            {
                $admin = auth()->user();
                $user = $admin->user;
                $friendships = Friend::where('friend_status', 'friends')
                    ->where(function ($query) use ($user) {
                        $query->where('user_id', $user->id)
                              ->orWhere('friend_id', $user->id);
                    })
                    ->get();
            
                $allFriends = [];
                foreach ($friendships as $friendship) {
                    $friendId = $friendship->user_id == $user->id ? $friendship->friend_id : $friendship->user_id;
                    $friend = User::find($friendId);
                    if ($friend) {
                        $countryName = Country::find($friend->country)->name ?? 'Unknown';
                        $allFriends[] = [
                            'id' => encrypt($friend->id),
                            'first_name' => $friend->first_name,
                            'last_name' => $friend->last_name,
                            'profile_pic' => $friend->profile_pic,
                            'country_name' => $countryName,
                        ];
                    }
                }
            
                return response()->json(['allFriends' => $allFriends]);
            }
            
            public function blockList()
            {
                $admin = auth()->user();
                $user = $admin->user;
                $friendships = Friend::where('friend_status', 'blocked')
                    ->where('blocked_by', $user->id)
                    ->get();
                
                $blockedUsers = [];
                
                foreach ($friendships as $friendship) {
                    $friendId = $friendship->user_id == $user->id ? $friendship->friend_id : $friendship->user_id;
                    $friend = User::find($friendId);
                    if ($friend) {
                        $countryName = Country::find($friend->country)->name ?? null;
                        $blockedUsers[] = [
                            'id' => encrypt($friend->id),
                            'friend' => $friend,
                            'country_name' => $countryName,
                        ];
                    }
                }
                
                return response()->json(['blockedUsers' => $blockedUsers]);
            }
            
            public function bestFriends()
            {
                $admin = auth()->user();
                $user = $admin->user;
                $friendships = Friend::where('friend_type', 'best')
                    ->where(function ($query) use ($user) {
                        $query->where('user_id', $user->id)
                              ->orWhere('friend_id', $user->id);
                    })
                    ->get();
            
                $allBestFriends = [];
                foreach ($friendships as $friendship) {
                    $friendId = $friendship->user_id == $user->id ? $friendship->friend_id : $friendship->user_id;
                    $friend = User::find($friendId);
                    if ($friend) {
                        $countryName = Country::find($friend->country)->name ?? null;
                        $allBestFriends[] = [
                            'id' => encrypt($friend->id),
                            'friend' => $friend,
                            'country_name' => $countryName,
                        ];
                    }
                }
            
                return response()->json(['allBestFriends' => $allBestFriends]);
            }
            

}
