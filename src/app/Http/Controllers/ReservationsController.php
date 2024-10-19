<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\User;
use App\Models\Reservation;
use App\Http\Requests\ReservationRequest;
use App\Mail\ReservationConfirmed;
use Illuminate\Support\Facades\Mail;

class ReservationsController extends Controller
{
    // 新規予約登録
    public function store(ReservationRequest $request, $shop_id){
        $user_id = Auth::id();
        $reservationData = $request->only([
            'date',
            'time',
            'numberPeople',
        ]);
        $reservationData['user_id'] = $user_id;
        $reservationData['shop_id'] = $shop_id;
        $reservation = Reservation::create($reservationData);

        Mail::to($reservation->user->email)->send(new ReservationConfirmed($reservation));

        return view('reservation.done');
    }

    // 予約内容変更ページの表示
    public function edit($id){
        $reservation = Reservation::findOrFail($id);
        return view('reservation.reservation_edit', compact('reservation'));
    }

    public function update(ReservationRequest $request, $id){
        $reservation = Reservation::findOrFail($id);
        $reservationData = $request->all();
        $reservation->update($reservationData);

        Mail::to($reservation->user->email)->send(new ReservationConfirmed($reservation));

        return view('reservation.edit_done');
    }

    // 予約削除
    public function destroy($id){
        $reservation = Reservation::findOrFail($id);
        if(\Auth::id() === $reservation->user_id){
            $reservation->delete();
        }
        return redirect()->route('mypage.show');
    }

    public function qrConfirmed(Reservation $reservation){
        return view('reservation.qr-result', compact('reservation'));
    }
}
