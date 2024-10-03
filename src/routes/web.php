<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ShopsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewsController;

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

// メール認証通知を表示するルート
Route::get('/email/verify', function(){
    return view('auth.verify-email');
})->name('verification.notice');
// メール認証リンクを検証するルート
Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request){
    $request->fulfill();
    return redirect()->route('thanks');
})->middleware(['auth', 'signed'])->name('verification.verify');
// メール認証リンクを再送信するルート
Route::post('/email/verification-notification', function(Request $request){
    $request->user()->sendEmailVerificationNotification();
    return back()->with('massage', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// ログイン関係
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [RegisterController::class, 'create'])->name('create.register');
Route::get('/thanks', function(){
    return view('auth.thanks');
})->name('thanks');

// トップページ（店舗一覧）
Route::get('/', [ShopsController::class, 'index'])->name('shops');
// 店舗検索機能
Route::get('/search', [ShopsController::class, 'search'])->name('shops.search');
// 店舗詳細ページ
Route::get('/detail/{shop_id}', [ShopsController::class, 'show'])->name('shop.detail');


// ログイン後
Route::middleware(['auth', 'verified'])->group(function(){
    Route::group(['prefix' => 'reservations'], function(){
        // 新規予約登録
        Route::post('{shop_id}', [ReservationsController::class, 'store'])->name('reservation.store');
        // 予約内容編集ページの表示
        Route::get('{id}/edit', [ReservationsController::class, 'edit'])->name('reservation.edit');
        // 予約内容の変更
        Route::put('{id}/edit', [ReservationsController::class, 'update'])->name('reservation.update');
        // 予約削除
        Route::delete('{id}/delete', [ReservationsController::class, 'destroy'])->name('reservation.destroy');
    });

    // マイページの表示
    Route::get('/mypage', [UsersController::class, 'show'])->name('mypage.show');

    // お気に入り関連
    Route::group(['prefix' => 'shops/{id}'], function(){
        // お気に入り登録
        Route::post('favorite', [FavoriteController::class, 'store'])->name('favorite');
        // お気に入り解除
        Route::delete('unfavorite', [FavoriteController::class, 'destroy'])->name('unfavorite');
    });

    // 評価投稿
    Route::group(['prefix' => 'reviews'], function(){
        // 一覧ページ
        Route::get('', [ReviewsController::class, 'index'])->name('reviews.index');
        // 投稿ページ
        Route::get('create/{id}', [ReviewsController::class, 'create'])->name('reviews.create');
        // 投稿内容確認
        Route::post('confirm', [ReviewsController::class, 'confirm'])->name('reviews.confirm');
        // 投稿処理
        Route::post('store', [ReviewsController::class, 'store'])->name('reviews.store');
    });
});
