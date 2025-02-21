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
use App\Http\Controllers\PaymentController;

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

// メール認証
Route::get('/email/verify', function(){
    return view('auth.verify-email');
})->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request){
    $request->fulfill();
    return redirect()->route('thanks');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function(Request $request){
    $request->user()->sendEmailVerificationNotification();
    return back()->with('massage', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ユーザー新規登録
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [RegisterController::class, 'create'])->name('create.register');
Route::get('/thanks', function(){
    return view('auth.thanks');
})->name('thanks');

// ログイン前閲覧可能
Route::get('/', [ShopsController::class, 'index'])->name('shop.index');
Route::get('/detail/{shop_id}', [ShopsController::class, 'show'])->name('shop.detail');
Route::get('/detail/{shop_id}/reviews', [ShopsController::class, 'showReviews'])->name('shop.reviews');

// QRコード読み取り先
Route::get('/reservations/qr/{reservation}', [ReservationsController::class, 'qrConfirmed'])->name('reservation.qrConfirmed');

// 一般ユーザー権限
Route::middleware(['auth', 'verified', 'can:user-higher'])->group(function(){
    // 一般ユーザー-予約
    Route::group(['prefix' => 'reservation'], function(){
        Route::post('{shop_id}', [ReservationsController::class, 'store'])->name('reservation.store');
        Route::group(['prefix' => '{reservation_id}'], function(){
            Route::get('edit', [ReservationsController::class, 'edit'])->name('reservation.edit');
            Route::put('edit', [ReservationsController::class, 'update'])->name('reservation.update');
            Route::delete('delete', [ReservationsController::class, 'destroy'])->name('reservation.destroy');
        });
    });

    // 一般ユーザー-マイページ
    Route::get('/mypage', [UsersController::class, 'show'])->name('mypage.show');

    // 一般ユーザー-お気に入り
    Route::group(['prefix' => 'shops/{shop_id}'], function(){
        Route::post('favorite', [FavoriteController::class, 'store'])->name('favorite');
        Route::delete('unfavorite', [FavoriteController::class, 'destroy'])->name('unfavorite');
    });

    // 一般ユーザー-レビュー
    Route::group(['prefix' => 'review'], function(){
        Route::get('', [ReviewsController::class, 'index'])->name('review.index');
        Route::get('create/{reservation_id}', [ReviewsController::class, 'create'])->name('review.create');
        Route::post('confirm/{reservation_id}', [ReviewsController::class, 'confirm'])->name('review.confirm');
        Route::post('store', [ReviewsController::class, 'store'])->name('review.store');
    });

    // 一般ユーザー-決済
    Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');
});

// 管理者権限
Route::middleware(['auth', 'verified', 'can:admin-higher'])->group(function(){
    // 管理者-店舗責任者
    Route::group(['prefix' => 'admin'], function(){
        Route::group(['prefix' => 'shop-manager'], function(){
            Route::get('', [AdminShopManagersController::class, 'index'])->name('admin.shop-managers.index');
            Route::get('create', [AdminShopManagersController::class, 'create'])->name('admin.shop-managers.create');
            Route::post('create', [AdminShopManagersController::class, 'store'])->name('admin.shop-managers.store');
            Route::group(['prefix' => '{manager_id}'], function(){
                Route::get('', [AdminShopManagersController::class, 'show'])->name('admin.shop-managers.show');
                Route::put('', [AdminShopManagersController::class, 'update'])->name('admin.shop-managers.update');
            });
        });
    });
});

// 店舗責任者権限
Route::middleware(['auth', 'verified', 'can:shopManager-higher'])->group(function(){
    // 店舗責任者-店舗
    Route::group(['prefix' => 'shop-manager'], function(){
        Route::get('', [ShopManagerShopsController::class, 'index'])->name('shopManager.index');
        Route::get('create', [ShopManagerShopsController::class, 'create'])->name('shopManager.create');
        Route::post('create', [ShopManagerShopsController::class, 'store'])->name('shopManager.store');
        Route::get('detail/{id}', [ShopManagerShopsController::class, 'show'])->name('shopManager.detail');
        Route::put('{id}/edit', [shopManagerShopsController::class, 'update'])->name('shopManager.update');

        // 店舗責任者-予約
        Route::group(['prefix' => 'reservations'], function(){
            Route::get('create/{id}', [ShopManagerReservationsController::class, 'create'])->name('shopManagerReservation.create');
            Route::post('create/{id}', [ShopManagerReservationsController::class, 'store'])->name('shopManagerReservation.store');
            Route::get('show/{id}', [ShopManagerReservationsController::class, 'show'])->name('shopManagerReservation.show');
            Route::put('{id}/edit', [ShopManagerReservationsController::class, 'update'])->name('shopManagerReservation.update');
            Route::delete('{id}/delete', [ShopManagerReservationsController::class, 'destroy'])->name('shopManagerReservation.destroy');
        });

        // 店舗責任者-メール送信
        Route::get('email-form/{id}', [ShopManagerSendMailsController::class, 'mailForm'])->name('shopManagerSendMail.form');
        Route::post('send-mail', [ShopManagerSendMailsController::class, 'sendMail'])->name('shopManagerSendMail.sendMail');
    });
});
