<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use App\Models\Review;
use Carbon\Carbon;
use App\Http\Requests\ReviewRequest;

class ReviewsController extends Controller
{
    public function index(){
        $user = Auth::user();
        $today = Carbon::now();
        $reservations = $user->reservations()
                            ->with(['shop', 'review'])
                            ->where(Reservation::raw("CONCAT(date, ' ', time)"), '<', $today)
                            ->orderBy('date', 'desc')
                            ->paginate(10);
        return view('review.review-index', compact('reservations'));
    }

    public function create($id){
        $reservation = Reservation::with('shop')->findOrFail($id);
        return view('review.review-create', compact('reservation'));
    }

    public function confirm(ReviewRequest $request, $id){
        $user = Auth::user();
        $reservation = Reservation::with('shop')->findOrFail($id);
        $review = $request->only([
            'is_anonymous',
            'evaluation',
            'comment',
        ]);
        return view('review.review-confirm', compact('review', 'user', 'reservation'));
    }

    public function store(Request $request){
        $user = Auth::user();
        $review = $request->only([
            'is_anonymous',
            'evaluation',
            'comment',
            'reservation_id',
            'shop_id',
        ]);

        $review['user_id'] = $user->id;

        Review::create($review);

        return view('review.review-done');
    }
}
