<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class UsersController extends Controller
{
    public function show(){
        $user = Auth::user();
        $reservations = $user->reservations()->orderBy('date', 'asc')->get();

        return view('mypage', ['reservations' => $reservations]);
    }
}