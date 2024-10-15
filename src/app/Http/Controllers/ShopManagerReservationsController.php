<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use App\Http\Requests\ReservationRequest;

class ShopManagerReservationsController extends Controller
{
    public function create($id){
        $shop = Shop::findOrFail($id);
        $users = User::where('role', 3)->get();
        return view('shop-manager.reservation-create', compact('shop', 'users'));
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
}
