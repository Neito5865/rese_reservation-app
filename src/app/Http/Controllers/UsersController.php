<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $reservations = $user->reservations()
            ->where('date', '>=', $today)
            ->orderBy('date', 'asc')
            ->get();

        $favoriteShops = $user->favorites()
            ->withPivot('created_at')
            ->orderBy('pivot_created_at', 'desc')
            ->get();

        return view('user.mypage', compact('reservations', 'favoriteShops'));
    }
}
