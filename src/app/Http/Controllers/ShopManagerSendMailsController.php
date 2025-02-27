<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Reservation;
use App\Mail\SendUserMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SendUserMailRequest;

class ShopManagerSendMailsController extends Controller
{
    public function mailForm($reservation_id)
    {
        $shopManager = Auth::user();
        $reservation = Reservation::with('shop')->find($reservation_id);

        if(!$reservation) {
            return $this->errorResponse('該当の予約が存在しません。', 404);
        }

        if ($reservation->shop->user_id !== $shopManager->id) {
            return $this->errorResponse('該当の予約が存在しません。', 403);
        }

        $user = $reservation->user;
        return view('shop_manager.send_email.send_email', compact('user', 'reservation'));
    }

    public function sendMail(SendUserMailRequest $request)
    {
        $recipientName = User::where('email', $request->input('to'))->first();

        if(!$recipientName){
            return $this->errorResponse('該当のユーザーが存在しません。', 404);
        }

        Mail::to($recipientName->email)->send(new SendUserMail($request->input('subject'), $request->input('message'), $recipientName->name));

        return redirect()->back()->with('success', 'メールが送信されました');
    }
}
