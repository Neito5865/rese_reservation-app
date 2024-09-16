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
}
