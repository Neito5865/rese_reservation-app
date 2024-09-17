<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopsController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ログイン関係
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [RegisterController::class, 'create'])->name('create.register');
Route::get('thanks', function(){
    return view('auth.thanks');
})->name('thanks');

// トップページ（店舗一覧）
Route::get('/', [ShopsController::class, 'index'])->name('shops');
// 店舗検索機能
Route::get('/search', [ShopsController::class, 'search'])->name('shops.search');
// 店舗詳細ページ
Route::get('/detail/{id}', [ShopsController::class, 'show'])->name('shop.show');





// 店舗詳細ページ
Route::get('/detail', function () {
    return view('detail');
});

// マイページ
Route::get('/mypage', function () {
    return view('mypage');
});

// 予約完了
Route::get('/done', function () {
    return view('done');
});
