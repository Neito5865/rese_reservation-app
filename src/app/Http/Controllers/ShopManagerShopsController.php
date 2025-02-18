<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            'shop_name',
            'area_id',
            'genre_id',
            'detail',
        ]);
        if($request->hasFile('shop_img')){
            $path = $request->file('shop_img')->store('public/shops');
            $shopManagerShop->shop_img  = 'shops/' . basename($path);
        }
        $shopManagerShop['user_id'] = $user_id;
        Shop::create($shopManagerShop);

        return back()->with('success', '店舗が作成されました。');
    }

    public function show($id){
        $shopManagerShop = Shop::find($id);
        if(!$shopManagerShop){
            return response()->view('errors.shopManagerShop-detail', ['message' => '該当の店舗が存在しません。'], 404);
        }

        $areas = Area::all();
        $genres = Genre::all();

        $shopManagerReservations = $shopManagerShop->reservations()->orderBy('date', 'asc')->orderBy('time', 'asc')->paginate(10);
        return view('shop-manager.detail', compact('shopManagerShop', 'areas', 'genres', 'shopManagerReservations'));
    }

    public function update(ShopRequest $request, $id){
        $shopManagerShop = Shop::findOrFail($id);

        if($request->hasFile('shop_img')){
            if($shopManagerShop->shop_img && Storage::exists('public/' . $shopManagerShop->shop_img)){
                Storage::delete('public/' . $shopManagerShop->shop_img);
            }

            $path = $request->file('shop_img')->store('public/shops');
            $shopManagerShop->shop_img = 'shops/' . basename($path);
        }

        $shopManagerShop->shop_name = $request->input('shop_name');
        $shopManagerShop->area_id = $request->input('area_id');
        $shopManagerShop->genre_id = $request->input('genre_id');
        $shopManagerShop->detail = $request->input('detail');
        $shopManagerShop->save();

        return back()->with('success', '店舗情報が保存されました');
    }
}
