<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request, $shop_id)
    {
        \Auth::user()->favorite($shop_id);
        return redirect()->back()->withInput($request->all());
    }

    public function destroy(Request $request, $shop_id)
    {
        \Auth::user()->unfavorite($shop_id);
        return redirect()->back()->withInput($request->all());
    }
}
