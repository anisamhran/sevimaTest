<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function index()
{
    $user = auth()->user();

    // Tandai semua sebagai dibaca
    $user->notifications()->where('is_read', false)->update(['is_read' => true]);

    $notifications = $user->notifications()->latest()->get();

    return view('notifications.index', compact('notifications'));
}

}
