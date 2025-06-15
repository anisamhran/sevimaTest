<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
{
    public function live(Request $request)
    {
        $query = $request->input('q');

        $users = User::where('username', 'like', "%$query%")
            ->orWhere('name', 'like', "%$query%")
            ->take(5)
            ->get(['id', 'name', 'username', 'profile_picture']);

        return response()->json($users);
    }
}
