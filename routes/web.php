<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/me', [ProfileController::class, 'show'])->name('profile.me');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/following', [FollowController::class, 'followingList'])->name('profile.following');

    Route::get('/explore', [\App\Http\Controllers\ExploreController::class, 'index'])->name('explore');
    Route::view('/notifications', 'notifications')->name('notifications');

    Route::get('/search/users', [\App\Http\Controllers\SearchController::class, 'live'])->name('search.live');
    Route::get('/user/{username}', [\App\Http\Controllers\ProfileController::class, 'publicProfile'])->name('user.profile');

    Route::resource('posts', PostController::class)->only(['create', 'store']);
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

// web.php
Route::post('/posts/{post}/like', [LikeController::class, 'ajaxToggle'])->name('posts.like');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comment');

    Route::post('/follow/{user}', [FollowController::class, 'toggle'])->name('follow.toggle');
    Route::get('/following', [FollowController::class, 'followingList'])->name('follow.following');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
// Dalam middleware('auth')->group(...)
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

Route::delete('/posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])->name('posts.comment.destroy');

});

require __DIR__.'/auth.php';
