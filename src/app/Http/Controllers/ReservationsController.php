<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\User;
use App\Models\Reservation;
use App\Http\Requests\ReservationRequest;
use App\Mail\ReservationConfirmed;
use Illuminate\Support\Facades\Mail;

class ReservationsController extends Controller
{
    public function store(ReservationRequest $request, $shop_id)
    {
        $user_id = Auth::id();
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

    public function edit($reservation_id)
    {
        $user = Auth::user();
        $reservation = Reservation::find($reservation_id);
        if(!$reservation){
            return response()->view('errors.error-page', ['message' => '該当の予約が存在しません。'], 404);
        }

        if ($user->id !== $reservation->user_id) {
            return response()->view('errors.error-page', ['message' => '該当の予約が存在しません。'], 403);
        }

        return view('reservation.reservation_edit', compact('reservation'));
    }

    public function update(ReservationRequest $request, $reservation_id)
    {
        $user = Auth::user();
        $reservation = Reservation::find($reservation_id);
        if(!$reservation){
            return response()->view('errors.error-page', ['message' => '該当の予約が存在しません。'], 404);
        }

        if ($user->id !== $reservation->user_id) {
            return response()->view('errors.error-page', ['message' => '該当の予約が存在しません。'], 403);
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

    public function destroy($reservation_id)
    {
        $user = Auth::user();
        $reservation = Reservation::find($reservation_id);
        if(!$reservation){
            return response()->view('errors.error-page', ['message' => '該当の予約が存在しません。'], 404);
        }

        if ($user->id !== $reservation->user_id) {
            return response()->view('errors.error-page', ['message' => '該当の予約が存在しません。'], 403);
        }

        $reservation->delete();

        return redirect()->route('mypage.show')->with('success', '予約をキャンセルしました。');
    }

    public function qrConfirmed(Reservation $reservation)
    {
        return view('reservation.qr-result', compact('reservation'));
    }
}
