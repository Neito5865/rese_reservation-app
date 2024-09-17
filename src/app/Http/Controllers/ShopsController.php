<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;


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

    public function show($id){
        $shop = Shop::findOrFail($id);
        return view('detail', ['shop' => $shop]);
    }
}
