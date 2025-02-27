<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Http\Requests\ShopRequest;

class ShopManagerShopsController extends Controller
{
    public function index(){
        $shopManager = Auth::user();
        $shopManagerShops = $shopManager->shops()
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('shop_manager.shop.index', compact('shopManagerShops'));
    }

    public function create(){
        $areas = Area::all();
        $genres = Genre::all();
        return view('shop_manager.shop.create', compact('areas', 'genres'));
    }

    public function store(ShopRequest $request){
        $user_id = Auth::id();
        $shopManagerShop = $request->only([
            'shop_name',
            'area_id',
            'genre_id',
            'detail',
        ]);
        if($request->hasFile('shop_img')){
            $path = $request->file('shop_img')->store('public/shops');
            $shopManagerShop['shop_img']  = 'shops/' . basename($path);
        }
        $shopManagerShop['user_id'] = $user_id;
        Shop::create($shopManagerShop);

        return back()->with('success', '店舗が作成されました。');
    }

    public function show($shop_id){
        $shopManager = Auth::user();
        $shopManagerShop = Shop::find($shop_id);

        if(!$shopManagerShop){
            return response()->view('errors.error-page', ['message' => '該当の店舗が存在しません。'], 404);
        }

        if($shopManagerShop->user_id !== $shopManager->id) {
            return response()->view('errors.error-page', ['message' => '該当の店舗が存在しません。'], 403);
        }

        $areas = Area::all();
        $genres = Genre::all();

        $shopManagerReservations = $shopManagerShop->reservations()->orderBy('date', 'desc')->orderBy('time', 'desc')->paginate(10);

        return view('shop_manager.shop.show', compact('shopManagerShop', 'areas', 'genres', 'shopManagerReservations'));
    }

    public function update(ShopRequest $request, $shop_id){
        $shopManager = Auth::user();
        $shopManagerShop = Shop::find($shop_id);

        if(!$shopManagerShop){
            return response()->view('errors.error-page', ['message' => '該当の店舗が存在しません。'], 404);
        }

        if($shopManagerShop->user_id !== $shopManager->id) {
            return response()->view('errors.error-page', ['message' => '該当の店舗が存在しません。'], 403);
        }

        if($request->hasFile('shop_img')){
            if($shopManagerShop->shop_img && Storage::exists('public/' . $shopManagerShop->shop_img)){
                Storage::delete('public/' . $shopManagerShop->shop_img);
            }

            $path = $request->file('shop_img')->store('public/shops');
            $shopManagerShop->shop_img = 'shops/' . basename($path);
        }

        $shopManagerShopData = $request->only([
            'shop_name',
            'area_id',
            'genre_id',
            'detail',
        ]);
        $shopManagerShop->update($shopManagerShopData);

        return back()->with('success', '店舗情報が保存されました');
    }
}
