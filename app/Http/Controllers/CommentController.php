<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Notifications\CommentNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Comment;
class CommentController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Post $post)
{
    $request->validate([
        'body' => 'required|string|max:1000',
    ]);

    /** @var \App\Models\User $user */
    $user = \Illuminate\Support\Facades\Auth::user();

    $comment = $post->comments()->create([
        'user_id' => $user->id,
        'body' => $request->body,
    ]);

    // Kirim notif kalau bukan komen ke post sendiri
    if ($post->user_id !== $user->id) {
        $post->user->notify(new CommentNotification($user, $post->id, $request->body));
    }
    

    return back()->with('success', 'Komentar berhasil dikirim.');
}

public function delete(Comment $comment) {
    $this->authorize('delete', $comment);
    $comment->delete();
    return back();
}

public function destroy(Post $post, Comment $comment)
{
    $this->authorize('delete', $comment);
    $comment->delete();

    return back()->with('success', 'Komentar berhasil dihapus.');
}

}
