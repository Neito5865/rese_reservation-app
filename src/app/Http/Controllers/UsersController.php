<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function show(){
        $user = Auth::user();
        $today = Carbon::today();
        $reservations = $user->reservations()
                            ->where('date', '>=', $today)
                            ->orderBy('date', 'asc')
                            ->get();
        $favoriteShops = $user->favorites()->get();

        return view('mypage', compact('reservations', 'favoriteShops'));
    }
}
