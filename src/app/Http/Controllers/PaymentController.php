<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Shop;

class PaymentController extends Controller
{
    public function showPaymentForm(){
        $shops = Shop::all();
        return view('payment.payment', compact('shops'));
    }
}
