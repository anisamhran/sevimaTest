<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        /** @var \App\Models\User $user */
        $authUser = \Illuminate\Support\Facades\Auth::user(); // bantu IDE & PHPStan

        if ($authUser->isFollowing($user)) {
            $authUser->following()->detach($user->id);
        } else {
            $authUser->following()->attach($user->id);
        }

        return back();
    }

    public function followingList()
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        $following = $user->following()->with('posts')->get();

        return view('profile.following', compact('user', 'following'));
    }

    
}
