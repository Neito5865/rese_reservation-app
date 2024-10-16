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

class ReservationsController extends Controller
{
    // 新規予約登録
    public function store(ReservationRequest $request, $shop_id){
        $user_id = Auth::id();
        $reservation = $request->only([
            'date',
            'time',
            'numberPeople',
        ]);
        $reservation['user_id'] = $user_id;
        $reservation['shop_id'] = $shop_id;
        Reservation::create($reservation);

        return view('reservation.done');
    }

    // 予約内容変更ページの表示
    public function edit($id){
        $reservation = Reservation::findOrFail($id);
        return view('reservation.reservation_edit', compact('reservation'));
    }

    public function update(ReservationRequest $request, $id){
        $reservation = $request->all();
        Reservation::findOrFail($id)->update($reservation);
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
}
