<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

     public function show()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $posts = $user->posts()->latest()->get();

        return view('profile.me', compact('user', 'posts'));
    }

    public function edit(Request $request): View
{
    return view('profile.edit', [
        'user' => $request->user(),
    ]);
}

public function publicProfile($username)
{
    $user = \App\Models\User::where('username', $username)->firstOrFail();
    $posts = $user->posts()->latest()->get();
    $isFollowing = auth()->check() && auth()->user()->following()->where('user_id', $user->id)->exists();
    $isCurrentUser = auth()->check() && auth()->user()->id === $user->id;

    return view('profile.public', compact('user', 'posts', 'isFollowing','isCurrentUser'));
}

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $request->user()->id],
        'bio' => ['nullable', 'string', 'max:500'],
        'profile_picture' => ['nullable', 'image', 'max:2048'],
    ]);

    $user = $request->user();

    // Handle foto profil
    if ($request->hasFile('profile_picture')) {
        $path = $request->file('profile_picture')->store('avatars', 'public');
        $user->profile_picture = $path;
    }

    $user->name = $request->name;
    $user->username = $request->username;
    $user->bio = $request->bio;
    $user->save();

    return Redirect::route('profile.me')->with('status', 'profile-updated');
}


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
