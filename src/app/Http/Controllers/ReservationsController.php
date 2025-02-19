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
    public function store(ReservationRequest $request, $shop_id){
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
