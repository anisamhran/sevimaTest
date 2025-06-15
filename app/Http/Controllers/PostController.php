<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;
    public function index()
{
    $user = Auth::user();

// Ambil postingan dari user sendiri dan orang yang dia follow
$posts = Post::whereIn('user_id', $user->following()->pluck('users.id')->push($user->id))
             ->latest()
             ->with(['user', 'likes', 'comments'])
             ->get();


    return view('dashboard', compact('posts'));
}

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'caption' => 'nullable|string|max:1000',
        ]);

        $imagePath = $request->file('image')->store('posts', 'public');

        Post::create([
            'user_id' => Auth::id(),
            'image' => $imagePath,
            'caption' => $request->caption,
        ]);

        return redirect()->route('dashboard')->with('success', 'Postingan berhasil diunggah!');
    }
    public function edit(Post $post)
{
    $this->authorize('update', $post);
    return view('posts.edit', compact('post'));
}

public function update(Request $request, Post $post)
{
    $this->authorize('update', $post);
    $request->validate(['caption' => 'required|string|max:1000', 'image' => 'nullable|image|max:2048']);

    if ($request->hasFile('image')) {
        $post->image = $request->file('image')->store('posts','public');
    }
    $post->caption = $request->caption;
    $post->save();

    return redirect()->route('posts.show', $post);
}

public function destroy(Post $post)
{
    $this->authorize('delete', $post);
    $post->delete();
    return redirect()->route('dashboard')->with('success', 'Postingan dihapus.');
}

public function show(Post $post)
{
    return view('posts.show', compact('post'));
}


    
// Removed the user method from PostController as it belongs to the Post model.
}
