<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/thanks', function () {
    return view('auth.thanks');
});

// トップページ（店舗一覧）
Route::get('/', function () {
    return view('index');
});

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
