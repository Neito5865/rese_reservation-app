<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
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

    public function create($reservation_id){
        $user = Auth::user();
        $reservation = Reservation::with('shop')->find($reservation_id);
        if(!$reservation){
            return response()->view('errors.error-page', ['message' => 'ページを表示できません。'], 404);
        }

        if ($user->id !== $reservation->user_id) {
            return response()->view('errors.error-page', ['message' => 'ページを表示できません。'], 403);
        }

        return view('review.review-create', compact('reservation'));
    }

    public function confirm(ReviewRequest $request, $reservation_id){
        $user = Auth::user();
        $reservation = Reservation::with('shop')->findOrFail($reservation_id);
        if(!$reservation){
            return response()->view('errors.error-page', ['message' => 'ページを表示できません。'], 404);
        }

        if ($user->id !== $reservation->user_id) {
            return response()->view('errors.error-page', ['message' => 'ページを表示できません。'], 403);
        }

        $review = $request->only([
            'is_anonymous',
            'evaluation',
            'comment',
        ]);

        if($request->input('action') === '＜ 修正する'){
            return redirect()->route('review.create', ['id' => $id])->withInput();
        }

        if($request->input('action') === 'レビューを投稿する'){
            return $this->store($request);
        }

        return view('review.review-confirm', compact('review', 'user', 'reservation'));
    }

    public function store(Request $request){
        $user = Auth::user();
        $reviewData = $request->only([
            'is_anonymous',
            'evaluation',
            'comment',
            'reservation_id',
            'shop_id',
        ]);
        $reviewData['user_id'] = $user->id;

        Review::create($reviewData);

        return view('review.review-done');
    }
}
