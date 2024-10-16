<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\ShopManagerReservationRequest;

class ShopManagerReservationsController extends Controller
{
    public function create($id){
        $shop = Shop::findOrFail($id);
        $users = User::where('role', 3)->get();
        return view('shop-manager.reservation-create', compact('shop', 'users'));
    }

    public function store(ShopManagerReservationRequest $request, $id){
        $shop = Shop::findOrFail($id);
        $reservation = $request->only([
            'date',
            'time',
            'numberPeople',
            'user_id',
        ]);
        $reservation['shop_id'] = $shop->id;
        Reservation::create($reservation);

        return back()->with('success', '新規予約を作成しました');
    }

    public function show($id){
        $shopManagerReservation = Reservation::find($id);
        if(!$shopManagerReservation){
            return response()->view('errors.shopManagerReservation-show', ['message' => '該当の予約が存在しません。'], 404);
        }
        return view('shop-manager.reservation-show', compact('shopManagerReservation'));
    }

    public function update(ReservationRequest $request, $id){
        $shopManagerReservation = $request->all();
        Reservation::findOrFail($id)->update($shopManagerReservation);

        return back()->with('success', '予約情報が変更されました');
    }

    public function destroy($id){
        $shopManagerReservation = Reservation::findOrFail($id);
        $shopId = $shopManagerReservation->shop->id;
        $shopManagerReservation->delete();
        return redirect()->route('shopManager.detail', ['id' => $shopId])->with('success', '予約を削除しました');
    }
}
