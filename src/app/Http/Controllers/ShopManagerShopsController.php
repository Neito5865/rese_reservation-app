<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\User;
use App\Http\Requests\ShopRequest;

class ShopManagerShopsController extends Controller
{
    public function index(){
        $shopManager = Auth::user();
        $shopManagerShops = $shopManager->shops()
                    ->orderBy('id', 'asc')
                    ->paginate(10);
        return view('shop-manager.index', compact('shopManagerShops'));
    }

    public function create(){
        $areas = Area::all();
        $genres = Genre::all();
        return view('shop-manager.create', compact('areas', 'genres'));
    }

    public function store(ShopRequest $request){
        $user_id = Auth::id();
        $shopManagerShop = $request->only([
            'shopName',
            'area_id',
            'genre_id',
            'detail',
        ]);
        if($request->hasFile('shopImg')){
            $path = $request->file('shopImg')->store('public/shops');
            $shopManagerShop['shopImg'] = 'shops/' . basename($path);
        }
        $shopManagerShop['user_id'] = $user_id;
        Shop::create($shopManagerShop);

        return back()->with('success', '店舗が作成されました。');
    }
}
