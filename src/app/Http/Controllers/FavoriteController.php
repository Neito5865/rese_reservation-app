<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store($id, Request $request){
    \Auth::user()->favorite($id);

    // 検索条件を含んだリダイレクト先を生成
    $queryParams = $request->only(['area_id', 'genre_id', 'keyword']); // 検索条件を取得
    return redirect()->route('shops.search', $queryParams); // 検索条件を保持してリダイレクト
}

    public function destroy($id, Request $request){
        \Auth::user()->unfavorite($id);

        // 検索条件を含んだリダイレクト先を生成
        $queryParams = $request->only(['area_id', 'genre_id', 'keyword']); // 検索条件を取得
        return redirect()->route('shops.search', $queryParams); // 検索条件を保持してリダイレクト
    }
}
