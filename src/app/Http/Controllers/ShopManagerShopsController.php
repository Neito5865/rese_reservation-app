<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopManagerShopsController extends Controller
{
    public function index(){
        return view('shop-manager.index');
    }
}
