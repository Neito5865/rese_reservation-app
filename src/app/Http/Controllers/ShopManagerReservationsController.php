<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\ShopManagerReservationRequest;
use App\Mail\ReservationConfirmed;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ShopManagerReservationsController extends Controller
{
    public function create($shop_id)
    {
        $shopManager = Auth::user();
        $shop = Shop::find($shop_id);
        $users = User::where('role', 3)->get();

        if(!$shop) {
            return $this->errorResponse('該当の店舗が存在しません。', 404);
        }

        if($shop->user_id !== $shopManager->id) {
            return $this->errorResponse('該当の店舗が存在しません。', 403);
        }

        return view('shop_manager.reservation.create', compact('shop', 'users'));
    }

    public function store(ShopManagerReservationRequest $request, $shop_id)
    {
        $shopManager = Auth::user();
        $shop = Shop::find($shop_id);

        if(!$shop){
            return $this->errorResponse('該当の店舗が存在しません。', 404);
        }

        if($shop->user_id !== $shopManager->id) {
            return $this->errorResponse('該当の店舗が存在しません。', 403);
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

    public function show($shop_id, $reservation_id)
    {
        $shopManager = Auth::user();
        $shop = Shop::find($shop_id);
        $reservation = Reservation::find($reservation_id);
        $reservationDateTime = $reservation->reservationDateTime;

        if(!$shop) {
            return $this->errorResponse('該当の店舗が存在しません。', 404);
        }

        if(!$reservation) {
            return $this->errorResponse('該当の予約が存在しません。', 404);
        }

        if($reservation->shop_id !== $shop->id) {
            return $this->errorResponse('該当の予約が存在しません。', 403);
        }

        if ($shop->user_id !== $shopManager->id) {
            return $this->errorResponse('該当の予約が存在しません。', 403);
        }

        return view('shop_manager.reservation.show', compact('shop', 'reservation', 'reservationDateTime'));
    }

    public function update(ReservationRequest $request, $shop_id, $reservation_id)
    {
        $shopManager = Auth::user();
        $shop = Shop::find($shop_id);
        $reservation = Reservation::find($reservation_id);

        if(!$shop) {
            return $this->errorResponse('該当の店舗が存在しません。', 404);
        }

        if(!$reservation) {
            return $this->errorResponse('該当の予約が存在しません。', 404);
        }

        if ($reservation->shop_id !== $shop->id) {
            return $this->errorResponse('該当の予約が存在しません。', 403);
        }

        if ($shop->user_id !== $shopManager->id) {
            return $this->errorResponse('該当の予約が存在しません。', 403);
        }

        if ($reservation->reservationDateTime < now()) {
            return redirect()->back()->with('error', '過去の予約は変更できません');
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

    public function destroy($shop_id, $reservation_id)
    {
        $shopManager = Auth::user();
        $shop = Shop::find($shop_id);
        $reservation = Reservation::find($reservation_id);

        if(!$shop) {
            return $this->errorResponse('該当の店舗が存在しません。', 404);
        }

        if(!$reservation) {
            return $this->errorResponse('該当の予約が存在しません。', 404);
        }

        if ($reservation->shop_id !== $shop->id) {
            return $this->errorResponse('該当の予約が存在しません。', 403);
        }

        if ($shop->user_id !== $shopManager->id) {
            return $this->errorResponse('該当の予約が存在しません。', 403);
        }

        if ($reservation->reservationDateTime < now()) {
            return redirect()->back()->with('error', '過去の予約はキャンセルできません');
        }

        $reservation->delete();

        return redirect()->route('shop-manager.shop.show', ['shop_id' => $shop->id])->with('success', '予約を削除しました');
    }
}
