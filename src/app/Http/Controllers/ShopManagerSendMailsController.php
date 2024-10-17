<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;
use App\Mail\SendUserMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SendUserMailRequest;

class ShopManagerSendMailsController extends Controller
{
    public function mailForm($id){
        $reservation = Reservation::findOrFail($id);
        $user = $reservation->user;
        return view('shop-manager.sendUserMail', compact('user', 'reservation'));
    }

    public function sendMail(SendUserMailRequest $request){
        $recipientName = User::where('email', $request->input('to'))->first();
        if(!$recipientName){
            return redirect()->back()->with('error', '該当するユーザーが見つかりませんでした');
        }
        Mail::to($recipientName->email)->send(new SendUserMail($request->input('subject'), $request->input('message'), $recipientName->name));

        return redirect()->back()->with('success', 'メールが送信されました');
    }
}
