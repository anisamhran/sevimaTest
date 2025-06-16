<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class ExploreController extends Controller
{
    public function index()
    {
        $user = \Auth::user();

        // Post dari user yang belum di-follow
        $posts = Post::where('user_id', '!=', $user->id)
            ->whereNotIn('user_id', $user->following()->pluck('users.id'))
            ->latest()
            ->take(18)
            ->with('user')
            ->get();

        // Rekomendasi user
        $suggestedUsers = User::where('id', '!=', $user->id)
            ->whereNotIn('id', $user->following()->pluck('users.id'))
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('explores.explore', compact('posts', 'suggestedUsers'));
    }
}
