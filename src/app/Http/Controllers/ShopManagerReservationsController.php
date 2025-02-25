<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\ShopManagerReservationRequest;
use App\Mail\ReservationConfirmed;
use Illuminate\Support\Facades\Mail;

class ShopManagerReservationsController extends Controller
{
    public function create($shop_id)
    {
        $shopManager = Auth::user();
        $shop = Shop::find($shop_id);
        $users = User::where('role', 3)->get();

        if(!$shop){
            return response()->view('errors.error-page', ['message' => '該当の店舗が存在しません。'], 404);
        }

        if($shop->user_id !== $shopManager->id) {
            return response()->view('errors.error-page', ['message' => '該当の店舗が存在しません。'], 403);
        }

        return view('shop_manager.reservation.create', compact('shop', 'users'));
    }

    public function store(ShopManagerReservationRequest $request, $shop_id)
    {
        $shopManager = Auth::user();
        $shop = Shop::find($shop_id);

        if(!$shop){
            return response()->view('errors.error-page', ['message' => '該当の店舗が存在しません。'], 404);
        }

        if($shop->user_id !== $shopManager->id) {
            return response()->view('errors.error-page', ['message' => '該当の店舗が存在しません。'], 403);
        }

        $reservationData = $request->only([
            'date',
            'time',
            'number_people',
            'user_id',
        ]);
        $reservationData['shop_id'] = $shop->id;
        $reservation = Reservation::create($reservationData);

        Mail::to($reservation->user->email)->send(new ReservationConfirmed($reservation));

        return back()->with('success', '新規予約を作成しました');
    }

    public function show($reservation_id)
    {
        $shopManager = Auth::user();

        $shopManagerReservation = Reservation::with('shop')->find($reservation_id);
        if(!$shopManagerReservation) {
            return response()->view('errors.error-page', ['message' => '該当の予約が存在しません。'], 404);
        }

        if ($shopManagerReservation->shop->user_id !== $shopManager->id) {
            return response()->view('errors.error-page', ['message' => '該当の予約が存在しません。'], 403);
        }

        return view('shop_manager.reservation.show', compact('shopManagerReservation'));
    }

    public function update(ReservationRequest $request, $reservation_id)
    {
        $shopManager = Auth::user();

        $reservation = Reservation::with('shop')->find($reservation_id);
        if(!$reservation) {
            return response()->view('errors.error-page', ['message' => '該当の予約が存在しません。'], 404);
        }

        if ($reservation->shop->user_id !== $shopManager->id) {
            return response()->view('errors.error-page', ['message' => '該当の予約が存在しません。'], 403);
        }

        $reservationData = $request->only([
            'date',
            'time',
            'number_people',
        ]);
        $reservation->update($reservationData);

        Mail::to($reservation->user->email)->send(new ReservationConfirmed($reservation));

        return back()->with('success', '予約情報が変更されました');
    }

    public function destroy($reservation_id)
    {
        $reservation = Reservation::find($reservation_id);
        if(!$reservation) {
            return response()->view('errors.error-page', ['message' => '該当の予約が存在しません。'], 404);
        }

        $shop = Shop::findOrFail($reservation->shop->id);
        $reservation->delete();

        return redirect()->route('shop-manager.shop.show', ['shop_id' => $shop->id])->with('success', '予約を削除しました');
    }
}
