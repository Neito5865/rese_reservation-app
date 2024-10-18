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
use App\Http\Controllers\AdminShopManagersController;
use App\Http\Controllers\ShopManagerShopsController;
use App\Http\Controllers\ShopManagerReservationsController;
use App\Http\Controllers\ShopManagerSendMailsController;

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
// 店舗のレビュー一覧
Route::get('/detail/reviews/{shop_id}', [ShopsController::class, 'showReviews'])->name('shop.reviews');

// QRコードリンク先
Route::get('/reservations/qr/{reservation}', [ReservationsController::class, 'qrConfirmed'])->name('reservation.qrConfirmed');


// ログイン後：一般ユーザー
Route::middleware(['auth', 'verified', 'can:user-higher'])->group(function(){
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
        Route::post('confirm/{id}', [ReviewsController::class, 'confirm'])->name('reviews.confirm');
        // 投稿処理
        Route::post('store', [ReviewsController::class, 'store'])->name('reviews.store');
    });
});

// ログイン後：管理者
Route::middleware(['auth', 'verified', 'can:admin-higher'])->group(function(){
    Route::group(['prefix' => 'admin'], function(){
        // 管理画面表示、店舗ユーザー一覧表示、検索機能
        Route::get('', [AdminShopManagersController::class, 'index'])->name('admin.index');
        // 店舗ユーザー情報詳細画面
        Route::get('detail/{id}', [AdminShopManagersController::class, 'show'])->name('admin.detail');
        // 店舗ユーザー編集機能
        Route::put('{id}/edit', [AdminShopManagersController::class, 'update'])->name('admin.update');
        // 店舗ユーザー新規作成
        Route::get('create', [AdminShopManagersController::class, 'create'])->name('admin.create');
        Route::post('create', [AdminShopManagersController::class, 'store'])->name('admin.store');
    });
});

// ログイン後：店舗ユーザー
Route::middleware(['auth', 'verified', 'can:shopManager-higher'])->group(function(){
    Route::group(['prefix' => 'shop-manager'], function(){
        // 管理画面表示、所有店舗一覧
        Route::get('', [ShopManagerShopsController::class, 'index'])->name('shopManager.index');
        // 店舗作成画面
        Route::get('create', [ShopManagerShopsController::class, 'create'])->name('shopManager.create');
        // 店舗作成処理
        Route::post('create', [ShopManagerShopsController::class, 'store'])->name('shopManager.store');
        // 店舗情報詳細画面表示、予約一覧表示
        Route::get('detail/{id}', [ShopManagerShopsController::class, 'show'])->name('shopManager.detail');
        Route::put('{id}/edit', [shopManagerShopsController::class, 'update'])->name('shopManager.update');

        Route::group(['prefix' => 'reservations'], function(){
            // 新規予約作成画面表示
            Route::get('create/{id}', [ShopManagerReservationsController::class, 'create'])->name('shopManagerReservation.create');
            // 新規予約作成
            Route::post('create/{id}', [ShopManagerReservationsController::class, 'store'])->name('shopManagerReservation.store');
            // 予約詳細画面
            Route::get('show/{id}', [ShopManagerReservationsController::class, 'show'])->name('shopManagerReservation.show');
            // 予約編集処理
            Route::put('{id}/edit', [ShopManagerReservationsController::class, 'update'])->name('shopManagerReservation.update');
            // 予約削除処理
            Route::delete('{id}/delete', [ShopManagerReservationsController::class, 'destroy'])->name('shopManagerReservation.destroy');
        });

        Route::get('email-form/{id}', [ShopManagerSendMailsController::class, 'mailForm'])->name('shopManagerSendMail.form');
        Route::post('send-mail', [ShopManagerSendMailsController::class, 'sendMail'])->name('shopManagerSendMail.sendMail');
    });
});
