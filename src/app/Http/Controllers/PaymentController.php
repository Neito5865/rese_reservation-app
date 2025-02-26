<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Shop;
Use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{
    public function showPaymentForm(){
        $shops = Shop::all();
        return view('payment.payment', compact('shops'));
    }

    public function processPayment(PaymentRequest $request){

        $shop = Shop::findOrFail($request->input('shop_id'));

        Stripe::setApikey(config('services.stripe.secret'));

        try {
            Charge::create([
                'amount' => $request->input('amount'),
                'currency' => 'jpy',
                'source' => $request->input('stripeToken'),
                'description' => '店舗名: ' . $shop->shopName . ' - 飲食店のお会計',
            ]);

            return redirect()->back()->with('success', '支払いが完了しました');
        } catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
