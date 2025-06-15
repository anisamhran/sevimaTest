<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Tandai semua sebagai sudah dibaca
    $user->unreadNotifications->markAsRead();

    $notifications = $user->notifications()->latest()->get();

    return view('notifications.index', compact('notifications'));
}


}
