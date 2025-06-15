<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user(); // bantu IDE & PHPStan

        $existing = $post->likes()->where('user_id', $user->id)->first();

        if ($existing) {
            $existing->delete();
        } else {
            $post->likes()->create([
                'user_id' => $user->id,
            ]);
        }

        return back();
    }

    public function ajaxToggle(Post $post) {
        $user = auth()->user();
        $existing = $post->likes()->where('user_id', $user->id)->first();
        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }
        return response()->json([
            'liked' => $liked,
            'count' => $post->likes()->count()
        ]);
    }
    

}
