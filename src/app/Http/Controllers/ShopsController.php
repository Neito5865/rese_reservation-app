<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Review;
use Carbon\Carbon;


class ShopsController extends Controller
{
    public function index(Request $request)
    {
        $query = Shop::with('area', 'genre');

        if ($request->hasAny(['area_id', 'genre_id', 'keyword'])) {
            $query->AreaSearch($request->area_id)
                ->GenreSearch($request->genre_id)
                ->KeywordSearch($request->keyword);
        }
        $shops = $query->get();
        $areas = Area::all();
        $genres = Genre::all();

        return view('index', compact('shops', 'areas', 'genres'));
    }

    public function show($shop_id)
    {
        $shop = Shop::find($shop_id);
        if(!$shop){
            return response()->view('errors.error-page', ['message' => '該当の店舗が存在しません。'], 404);
        }

        $reviews = Review::where('shop_id', $shop_id)->get();
        $averageRating = $reviews->avg('evaluation') ? : 0;
        $reviewCount = $reviews->count();

        $userReservations = collect();
        if(Auth::check()){
            $today = Carbon::today();
            $userReservations = Reservation::where('user_id', Auth::id())
                ->where('shop_id', $shop_id)
                ->where('date', '>=', $today)
                ->with('shop')
                ->get();
        }

        return view('detail', compact('shop', 'userReservations', 'averageRating', 'reviewCount'));
    }

    public function showReviews($shop_id)
    {
        $shop = Shop::find($shop_id);
        if(!$shop){
            return response()->view('errors.error-page', ['message' => 'ページが存在しません。'], 404);
        }
        $reviews = Review::where('shop_id', $shop_id)->orderBy('id','desc')->paginate(10);

        return view('shop-reviews', compact('shop', 'reviews'));
    }
}
