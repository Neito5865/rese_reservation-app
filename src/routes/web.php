<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\UsersController;

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
Route::get('/detail/{shop_id}', [ShopsController::class, 'show'])->name('shop.detail');


// ログイン後
Route::group(['middleware' => 'auth'], function(){
    // 新規予約登録
    Route::post('/reservations/{shop_id}', [ReservationsController::class, 'store'])->name('reservation.store');
    // 予約削除
    Route::delete('/reservations/{id}/delete', [ReservationsController::class, 'destroy'])->name('reservation.destroy');
    // マイページの表示
    Route::get('/mypage', [UsersController::class, 'show'])->name('mypage.show');
});
