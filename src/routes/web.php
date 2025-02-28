<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\ShopsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AdminShopManagersController;
use App\Http\Controllers\ShopManagerShopsController;
use App\Http\Controllers\ShopManagerReservationsController;
use App\Http\Controllers\ShopManagerSendMailsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

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


// ログイン前閲覧可能
Route::get('/', [ShopsController::class, 'index'])->name('shop.index');
Route::get('/shop/{shop_id}', [ShopsController::class, 'show'])->name('shop.show');
Route::get('/shop/{shop_id}/reviews', [ShopsController::class, 'showReviews'])->name('shop.reviews');
Route::get('/thanks', function () {
    return view('auth.thanks');
})->name('thanks');

// 一般ユーザー権限
Route::middleware(['auth', 'verified', 'can:user-higher'])->group(function () {
    // 一般ユーザー-マイページ
    Route::get('mypage', [UsersController::class, 'show'])->name('mypage.show');

    Route::prefix('shop/{shop_id}')->group(function () {
        // 一般ユーザー-お気に入り
        Route::post('favorite', [FavoriteController::class, 'store'])->name('favorite');
        Route::delete('unfavorite', [FavoriteController::class, 'destroy'])->name('unfavorite');

        // 一般ユーザー-予約
        Route::prefix('reservation')->group(function () {
            Route::post('', [ReservationsController::class, 'store'])->name('reservation.store');
            Route::prefix('{reservation_id}')->group(function () {
                Route::get('edit', [ReservationsController::class, 'edit'])->name('reservation.edit');
                Route::put('', [ReservationsController::class, 'update'])->name('reservation.update');
                Route::delete('', [ReservationsController::class, 'destroy'])->name('reservation.destroy');
            });
        });
    });

    // 一般ユーザー-レビュー
    Route::prefix('review')->group(function () {
        Route::get('', [ReviewsController::class, 'index'])->name('review.index');
        Route::get('create/{reservation_id}', [ReviewsController::class, 'create'])->name('review.create');
        Route::post('confirm/{reservation_id}', [ReviewsController::class, 'confirm'])->name('review.confirm');
        Route::post('', [ReviewsController::class, 'store'])->name('review.store');
    });

    // 一般ユーザー-決済
    Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');
});

// 管理者権限
Route::middleware(['auth', 'verified', 'can:admin-higher'])->group(function () {
    // 管理者-店舗責任者
    Route::prefix('admin')->group(function () {
        Route::prefix('shop-manager')->group(function () {
            Route::get('', [AdminShopManagersController::class, 'index'])->name('admin.shop-manager.index');
            Route::get('create', [AdminShopManagersController::class, 'create'])->name('admin.shop-manager.create');
            Route::post('', [AdminShopManagersController::class, 'store'])->name('admin.shop-manager.store');
            Route::prefix('{manager_id}')->group(function () {
                Route::get('', [AdminShopManagersController::class, 'show'])->name('admin.shop-manager.show');
                Route::put('', [AdminShopManagersController::class, 'update'])->name('admin.shop-manager.update');
            });
        });
    });
});

// 店舗責任者権限
Route::middleware(['auth', 'verified', 'can:shopManager-higher'])->group(function () {
    Route::prefix('shop-manager')->group(function () {
        // 店舗責任者-店舗
        Route::prefix('shop')->group(function () {
            Route::get('', [ShopManagerShopsController::class, 'index'])->name('shop-manager.shop.index');
            Route::get('create', [ShopManagerShopsController::class, 'create'])->name('shop-manager.shop.create');
            Route::post('', [ShopManagerShopsController::class, 'store'])->name('shop-manager.shop.store');
            Route::prefix('{shop_id}')->group(function () {
                Route::get('', [ShopManagerShopsController::class, 'show'])->name('shop-manager.shop.show');
                Route::put('', [ShopManagerShopsController::class, 'update'])->name('shop-manager.shop.update');

                // 店舗責任者-予約
                Route::prefix('reservation')->group(function () {
                    Route::get('create', [ShopManagerReservationsController::class, 'create'])->name('shop-manager.reservation.create');
                    Route::post('', [ShopManagerReservationsController::class, 'store'])->name('shop-manager.reservation.store');
                    Route::prefix('{reservation_id}')->group(function () {
                        Route::get('', [ShopManagerReservationsController::class, 'show'])->name('shop-manager.reservation.show');
                        Route::put('', [ShopManagerReservationsController::class, 'update'])->name('shop-manager.reservation.update');
                        Route::delete('', [ShopManagerReservationsController::class, 'destroy'])->name('shop-manager.reservation.destroy');
                    });
                });
            });
        });

        // 店舗責任者-メール送信
        Route::get('email-form/{reservation_id}', [ShopManagerSendMailsController::class, 'mailForm'])->name('shop-manager.send-mail.form');
        Route::post('send-mail', [ShopManagerSendMailsController::class, 'sendMail'])->name('shop-manager.send-mail.send');
    });
});

// ログイン処理
Route::post('login', [AuthenticatedSessionController::class, 'store'])->middleware('email')->name('login.store');
// 新規ユーザー登録
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

// メール認証
Route::get('/email/verify', function(){
    return view('auth.verify-email');
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function($id, $hash){
    $user = User::find($id);

    if (!$user) {
        return redirect()->route('login')->with('error', 'ユーザーが見つかりませんでした。');
    }
    if (!hash_equals($hash, sha1($user->getEmailForVerification()))) {
        return redirect()->route('login')->with('error', '無効な認証リンクです。');
    }
    if ($user->hasVerifiedEmail()) {
        return redirect()->route('thanks')->with('message', 'すでに認証済みです。');
    }

    $user->markEmailAsVerified();
    session()->forget('unauthenticated_user');
    return redirect()->route('thanks')->with('message', 'メール認証が完了しました。');
})->name('verification.verify');

Route::post('/email/verification-notification', function(Request $request){
    if (session()->has('unauthenticated_user')) {
        session()->get('unauthenticated_user')->sendEmailVerificationNotification();
        session()->put('resent', true);
    }
    return back()->with('massage', 'Verification link sent!');
})->middleware('throttle:6,1')->name('verification.send');

// QRコード読み取り先
Route::get('/reservations/qr/{reservation}', [ReservationsController::class, 'qrConfirmed'])->name('reservation.qrConfirmed');
