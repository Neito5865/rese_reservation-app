@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="mypage-content">
        <div class="mypage__user-name">
            <p>testさん</p>
        </div>
        <div class="mypage__flex">
            <div class="mypage-left">
                <div class="reservation-status__title">
                    <h2>予約状況</h2>
                </div>
                <div class="reservation-status__container">
                    <div class="status-card">
                        <div class="status-card__heading-btn--flex">
                            <div class="status-card__heading">
                                <i class="fa-regular fa-clock"></i><h3>予約1</h3>
                            </div>
                            <form method="" action="" class="status-card-form">
                                <button class="status-card__btn--delete" type="submit">×</button>
                            </form>
                        </div>
                        <table class="status-card-table">
                            <tr class="status-card-table__row">
                                <th class="status-card-table__heading">Shop</th>
                                <td class="status-card-table__item">仙人</td>
                            </tr>
                            <tr class="status-card-table__row">
                                <th class="status-card-table__heading">Date</th>
                                <td class="status-card-table__item">2024-09-11</td>
                            </tr>
                            <tr class="status-card-table__row">
                                <th class="status-card-table__heading">Time</th>
                                <td class="status-card-table__item">17:00</td>
                            </tr>
                            <tr class="status-card-table__row">
                                <th class="status-card-table__heading">Number</th>
                                <td class="status-card-table__item">1人</td>
                            </tr>
                        </table>
                    </div>
                    <div class="status-card">
                        <div class="status-card__heading-btn--flex">
                            <div class="status-card__heading">
                                <i class="fa-regular fa-clock"></i><h3>予約2</h3>
                            </div>
                            <form method="" action="" class="status-card-form">
                                <button class="status-card__btn--delete" type="submit">×</button>
                            </form>
                        </div>
                        <table class="status-card-table">
                            <tr class="status-card-table__row">
                                <th class="status-card-table__heading">Shop</th>
                                <td class="status-card-table__item">仙人</td>
                            </tr>
                            <tr class="status-card-table__row">
                                <th class="status-card-table__heading">Date</th>
                                <td class="status-card-table__item">2024-09-11</td>
                            </tr>
                            <tr class="status-card-table__row">
                                <th class="status-card-table__heading">Time</th>
                                <td class="status-card-table__item">17:00</td>
                            </tr>
                            <tr class="status-card-table__row">
                                <th class="status-card-table__heading">Number</th>
                                <td class="status-card-table__item">1人</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mypage-right">
                <div class="favorite-shops__title">
                    <h2>お気に入り店舗</h2>
                </div>
                <div class="favorite-card__flex">
                    <div class="favorite-card">
                        <div class="favorite-card__img">
                            <img src="https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg" alt="仙人">
                        </div>
                        <div class="favorite-card__content">
                            <h3 class="favorite-card__shop-name">仙人</h3>
                            <div class="favorite-card__tag">
                                <span class="favorite-card__tag--area">#東京都</span>
                                <span class="favorite-card__tag--genre">#寿司</span>
                            </div>
                            <div class="favorite-card__content--flex">
                                <div class="favorite-card__link">
                                    <a href="" class="favorite-card__link-detail">詳しくみる</a>
                                </div>
                                <form class="favorite-card__form">
                                    @csrf
                                    <button class="favorite-card__btn--favorite" type="submit"><i class="fa-solid fa-heart"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="favorite-card">
                        <div class="favorite-card__img">
                            <img src="https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg" alt="仙人">
                        </div>
                        <div class="favorite-card__content">
                            <h3 class="favorite-card__shop-name">仙人</h3>
                            <div class="favorite-card__tag">
                                <span class="favorite-card__tag--area">#東京都</span>
                                <span class="favorite-card__tag--genre">#寿司</span>
                            </div>
                            <div class="favorite-card__content--flex">
                                <div class="favorite-card__link">
                                    <a href="" class="favorite-card__link-detail">詳しくみる</a>
                                </div>
                                <form class="favorite-card__form">
                                    @csrf
                                    <button class="favorite-card__btn--favorite" type="submit"><i class="fa-solid fa-heart"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="favorite-card">
                        <div class="favorite-card__img">
                            <img src="https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg" alt="仙人">
                        </div>
                        <div class="favorite-card__content">
                            <h3 class="favorite-card__shop-name">仙人</h3>
                            <div class="favorite-card__tag">
                                <span class="favorite-card__tag--area">#東京都</span>
                                <span class="favorite-card__tag--genre">#寿司</span>
                            </div>
                            <div class="favorite-card__content--flex">
                                <div class="favorite-card__link">
                                    <a href="" class="favorite-card__link-detail">詳しくみる</a>
                                </div>
                                <form class="favorite-card__form">
                                    @csrf
                                    <button class="favorite-card__btn--favorite" type="submit"><i class="fa-solid fa-heart"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
