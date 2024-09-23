<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Reservation;
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

        return response()->json(['shops' => $shops]);
    }

    public function show($shop_id){
        $shop = Shop::findOrFail($shop_id);

        $userReservations = collect();
        if(Auth::check()){
            $today = Carbon::today();
            $userReservations = Reservation::where('user_id', Auth::id())
                                            ->where('shop_id', $shop_id)
                                            ->where('date', '>=', $today)
                                            ->with('shop')
                                            ->get();
        }

        return view('detail', compact('shop', 'userReservations'));
    }
}
