<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Shop;
use Carbon\Carbon;

class ReviewsController extends Controller
{
    public function index(){
        $user = Auth::user();
        $today = Carbon::now();
        $reservations = $user->reservations()
                            ->with(['shop', 'review'])
                            ->where('date', '<=', $today)
                            ->orderBy('date', 'asc')
                            ->get();
        return view('review.review-index', compact('reservations'));
    }
}
