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
    public function index(){
        $shops = Shop::with('area', 'genre')->get();
        $areas = Area::all();
        $genres = Genre::all();
        return view('index', compact('shops', 'areas', 'genres'));
    }

    public function search(Request $request){
        $shops = Shop::with('area', 'genre')->AreaSearch($request->area_id)->GenreSearch($request->genre_id)->KeywordSearch($request->keyword)->get();
        $areas = Area::all();
        $genres = Genre::all();
        return view('index', compact('shops', 'areas', 'genres'));
    }

    public function show($shop_id){
        $shop = Shop::find($shop_id);
        if(!$shop){
            return response()->view('errors.shop-detail', ['message' => '該当の店舗が存在しません。'], 404);
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

    public function showReviews($shop_id){
        $shop = Shop::find($shop_id);
        if(!$shop){
            return response()->view('errors.shop-review', ['message' => 'レビューが存在しません。'], 404);
        }
        $reviews = Review::where('shop_id', $shop_id)->orderBy('id','desc')->paginate(10);

        return view('shop-reviews', compact('shop', 'reviews'));
    }
}
