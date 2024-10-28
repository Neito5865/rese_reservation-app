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

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [RegisterController::class, 'create'])->name('create.register');
Route::get('/thanks', function(){
    return view('auth.thanks');
})->name('thanks');

Route::get('/', [ShopsController::class, 'index'])->name('shops');
Route::get('/search', [ShopsController::class, 'search'])->name('shops.search');
Route::get('/detail/{shop_id}', [ShopsController::class, 'show'])->name('shop.detail');
Route::get('/detail/reviews/{shop_id}', [ShopsController::class, 'showReviews'])->name('shop.reviews');

Route::get('/reservations/qr/{reservation}', [ReservationsController::class, 'qrConfirmed'])->name('reservation.qrConfirmed');

Route::middleware(['auth', 'verified', 'can:user-higher'])->group(function(){
    Route::group(['prefix' => 'reservations'], function(){
        Route::post('{shop_id}', [ReservationsController::class, 'store'])->name('reservation.store');
        Route::get('{id}/edit', [ReservationsController::class, 'edit'])->name('reservation.edit');
        Route::put('{id}/edit', [ReservationsController::class, 'update'])->name('reservation.update');
        Route::delete('{id}/delete', [ReservationsController::class, 'destroy'])->name('reservation.destroy');
    });

    Route::get('/mypage', [UsersController::class, 'show'])->name('mypage.show');

    Route::group(['prefix' => 'shops/{id}'], function(){
        Route::post('favorite', [FavoriteController::class, 'store'])->name('favorite');
        Route::delete('unfavorite', [FavoriteController::class, 'destroy'])->name('unfavorite');
    });

    Route::group(['prefix' => 'reviews'], function(){
        Route::get('', [ReviewsController::class, 'index'])->name('reviews.index');
        Route::get('create/{id}', [ReviewsController::class, 'create'])->name('reviews.create');
        Route::post('confirm/{id}', [ReviewsController::class, 'confirm'])->name('reviews.confirm');
        Route::post('store', [ReviewsController::class, 'store'])->name('reviews.store');
    });

    Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');
});

Route::middleware(['auth', 'verified', 'can:admin-higher'])->group(function(){
    Route::group(['prefix' => 'admin'], function(){
        Route::get('', [AdminShopManagersController::class, 'index'])->name('admin.index');
        Route::get('detail/{id}', [AdminShopManagersController::class, 'show'])->name('admin.detail');
        Route::put('{id}/edit', [AdminShopManagersController::class, 'update'])->name('admin.update');
        Route::get('create', [AdminShopManagersController::class, 'create'])->name('admin.create');
        Route::post('create', [AdminShopManagersController::class, 'store'])->name('admin.store');
    });
});

Route::middleware(['auth', 'verified', 'can:shopManager-higher'])->group(function(){
    Route::group(['prefix' => 'shop-manager'], function(){
        Route::get('', [ShopManagerShopsController::class, 'index'])->name('shopManager.index');
        Route::get('create', [ShopManagerShopsController::class, 'create'])->name('shopManager.create');
        Route::post('create', [ShopManagerShopsController::class, 'store'])->name('shopManager.store');
        Route::get('detail/{id}', [ShopManagerShopsController::class, 'show'])->name('shopManager.detail');
        Route::put('{id}/edit', [shopManagerShopsController::class, 'update'])->name('shopManager.update');

        Route::group(['prefix' => 'reservations'], function(){
            Route::get('create/{id}', [ShopManagerReservationsController::class, 'create'])->name('shopManagerReservation.create');
            Route::post('create/{id}', [ShopManagerReservationsController::class, 'store'])->name('shopManagerReservation.store');
            Route::get('show/{id}', [ShopManagerReservationsController::class, 'show'])->name('shopManagerReservation.show');
            Route::put('{id}/edit', [ShopManagerReservationsController::class, 'update'])->name('shopManagerReservation.update');
            Route::delete('{id}/delete', [ShopManagerReservationsController::class, 'destroy'])->name('shopManagerReservation.destroy');
        });

        Route::get('email-form/{id}', [ShopManagerSendMailsController::class, 'mailForm'])->name('shopManagerSendMail.form');
        Route::post('send-mail', [ShopManagerSendMailsController::class, 'sendMail'])->name('shopManagerSendMail.sendMail');
    });
});
