@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="mypage-content">
        <div class="mypage__user-name">
            <p>{{ Auth::user()->name }}さん</p>
        </div>
        <div class="mypage__flex">
            <div class="mypage-left">
                <div class="reservation-status__title">
                    <h2>予約状況</h2>
                </div>
                <div class="reservation-status__container">
                    @foreach($reservations as $reservation)
                        <div class="status-card">
                            <div class="status-card__heading-btn--flex">
                                <div class="status-card__heading">
                                    <i class="fa-regular fa-clock"></i><h3>予約{{ $loop->iteration }}</h3>
                                </div>
                                <div class="status-card__btn--modal">
                                    <button class="status-card__btn--delete open-modal-btn" id="open-modal" type="submit">&times;</button>
                                </div>
                            </div>
                            <table class="status-card-table">
                                <tr class="status-card-table__row">
                                    <th class="status-card-table__heading">Shop</th>
                                    <td class="status-card-table__item">{{ $reservation->shop->shopName }}</td>
                                </tr>
                                <tr class="status-card-table__row">
                                    <th class="status-card-table__heading">Date</th>
                                    <td class="status-card-table__item">{{ $reservation->date }}</td>
                                </tr>
                                <tr class="status-card-table__row">
                                    <th class="status-card-table__heading">Time</th>
                                    <td class="status-card-table__item">{{\Carbon\Carbon::parse($reservation->time)->format('H:i')}}</td>
                                </tr>
                                <tr class="status-card-table__row">
                                    <th class="status-card-table__heading">Number</th>
                                    <td class="status-card-table__item">{{ $reservation->numberPeople }}人</td>
                                </tr>
                            </table>
                        </div>
                    @endforeach
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

    <div id="modal" class="modal">
        <div class="modal-content">
            <span id="close-modal" class="close-btn">&times;</span>
            <h2>こちらの予約を削除してもよろしいですか？</h2>
            <table class="modal-table">
                <tr class="modal__row">
                    <th class="modal-table__heading">Shop</th>
                    <td class="modal-table__item">{{ $reservation->shop->shopName }}</td>
                </tr>
                <tr class="modal-table__row">
                    <th class="modal-table__heading">Date</th>
                    <td class="modal-table__item">{{ $reservation->date }}</td>
                </tr>
                <tr class="modal-table__row">
                    <th class="modal-table__heading">Time</th>
                    <td class="modal-table__item">{{\Carbon\Carbon::parse($reservation->time)->format('H:i')}}</td>
                </tr>
                <tr class="modal-table__row">
                    <th class="smodal-table__heading">Number</th>
                    <td class="modal-table__item">{{ $reservation->numberPeople }}人</td>
                </tr>
            </table>
            <form class="delete-form" action="" method="">
                @csrf
                <div class="delete-form__button">
                    <input type="hidden" name="id" id="modal-id">
                    <input class="delete-form__button-submit" type="submit" value="削除">
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('open-modal').onclick = function(){
            document.getElementById('modal').style.display = 'block';
        }
        document.getElementById('close-modal').onclick = function(){
            document.getElementById('modal').style.display = 'none';
        }
        window.onclick = function(event){
            if(event.target == document.getElementById('modal')){
                document.getElementById('modal').style.display = 'none';
            }
        }
    </script>
@endsection
