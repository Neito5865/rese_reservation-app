<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Shop;
use App\Http\Requests\ReservationRequest;
use App\Mail\ReservationConfirmed;
use Illuminate\Support\Facades\Mail;

class ReservationsController extends Controller
{
    public function store(ReservationRequest $request, $shop_id)
    {
        $user_id = Auth::id();
        $shop = Shop::find($shop_id);

        if(!$shop) {
            return $this->errorResponse('該当の店舗が存在しません。', 404);
        }

        $reservationData = $request->only([
            'date',
            'time',
            'number_people',
        ]);
        $reservationData['user_id'] = $user_id;
        $reservationData['shop_id'] = $shop_id;

        $reservation = Reservation::create($reservationData);

        Mail::to($reservation->user->email)->send(new ReservationConfirmed($reservation));

        return view('reservation.done');
    }

    public function edit($shop_id, $reservation_id)
    {
        $user = Auth::user();
        $shop = Shop::find($shop_id);
        $reservation = Reservation::find($reservation_id);

        if(!$shop) {
            return $this->errorResponse('該当の店舗が存在しません。', 404);
        }

        if(!$reservation) {
            return $this->errorResponse('該当の予約が存在しません。', 404);
        }

        if($reservation->shop_id !== $shop->id) {
            return $this->errorResponse('該当の予約が存在しません。', 403);
        }

        if ($user->id !== $reservation->user_id) {
            return $this->errorResponse('該当の予約が存在しません。', 403);
        }

        return view('reservation.reservation_edit', compact('reservation'));
    }

    public function update(ReservationRequest $request, $shop_id, $reservation_id)
    {
        $user = Auth::user();
        $shop = Shop::find($shop_id);
        $reservation = Reservation::find($reservation_id);

        if(!$shop) {
            return $this->errorResponse('該当の店舗が存在しません。', 404);
        }

        if(!$reservation) {
            return $this->errorResponse('該当の予約が存在しません。', 404);
        }

        if($reservation->shop_id !== $shop->id) {
            return $this->errorResponse('該当の予約が存在しません。', 403);
        }

        if ($user->id !== $reservation->user_id) {
            return $this->errorResponse('該当の予約が存在しません。', 403);
        }

        $reservationData = $request->only([
            'date',
            'time',
            'number_people',
        ]);
        $reservation->update($reservationData);

        Mail::to($reservation->user->email)->send(new ReservationConfirmed($reservation));

        return view('reservation.edit_done');
    }

    public function destroy($shop_id, $reservation_id)
    {
        $user = Auth::user();
        $shop = Shop::find($shop_id);
        $reservation = Reservation::find($reservation_id);

        if(!$shop) {
            return $this->errorResponse('該当の店舗が存在しません。', 404);
        }

        if(!$reservation) {
            return $this->errorResponse('該当の予約が存在しません。', 404);
        }

        if($reservation->shop_id !== $shop->id) {
            return $this->errorResponse('該当の予約が存在しません。', 403);
        }

        if ($user->id !== $reservation->user_id) {
            return $this->errorResponse('該当の予約が存在しません。', 403);
        }

        $reservation->delete();

        return redirect()->route('mypage.show')->with('success', '予約をキャンセルしました。');
    }

    public function qrConfirmed(Reservation $reservation)
    {
        return view('reservation.qr-result', compact('reservation'));
    }
}
