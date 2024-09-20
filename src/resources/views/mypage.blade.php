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
                                    <a class="status-card__link--delete modal-trigger" href="#modal"
                                        data-id="{{ $reservation->id }}"
                                        data-shop="{{ $reservation->shop->shopName }}"
                                        data-date="{{ $reservation->date }}"
                                        data-time="{{\Carbon\Carbon::parse($reservation->time)->format('H:i')}}"
                                        data-number="{{ $reservation->numberPeople }}">
                                        &times;
                                    </a>
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
        <div class="modal__contents">
            <div class="modal-close">
                <a class="modal-close__link" href="#">&times;</a>
            </div>
            <div class="modal__content">
                <div class="modal__message">
                    <p>こちらの予約をキャンセルしてもよろしいですか？</p>
                </div>
                <div class="modal-table">
                    <table class="modal-table__inner">
                        <tr class="modal-table__row">
                            <th class="modal-table__heading">Shop</th>
                            <td class="modal-table__item" id="modal-shop"></td>
                        </tr>
                        <tr class="modal-table__row">
                            <th class="modal-table__heading">Date</th>
                            <td class="modal-table__item" id="modal-date"></td>
                        </tr>
                        <tr class="modal-table__row">
                            <th class="modal-table__heading">Time</th>
                            <td class="modal-table__item" id="modal-time"></td>
                        </tr>
                        <tr class="modal-table__row">
                            <th class="modal-table__heading">Number</th>
                            <td class="modal-table__item" id="modal-number"></td>
                        </tr>
                    </table>
                </div>
                <div class="buttons">
                    <div class="modal-close__back">
                        <a class="modal-close__back--link" href="/mypage">&lt; 戻る</a>
                    </div>
                    <form class="delete-form" action="/mypage/delete" method="POST">
                        @method('DELETE')
                        @csrf
                        <div class="delete-form__button">
                            <input type="hidden" name="id" id="modal-id">
                            <input class="delete-form__button-submit" type="submit" value="キャンセル">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modalTriggers = document.querySelectorAll('.modal-trigger');
            var modal = document.getElementById('modal'); // モーダルの要素を取得
            modalTriggers.forEach(function(trigger) {
                trigger.addEventListener('click', function(event) {
                    event.preventDefault(); // デフォルトのリンク動作を無効化

                    // モーダル内のデータを更新
                    document.getElementById('modal-shop').innerText = this.getAttribute('data-shop');
                    document.getElementById('modal-date').innerText = this.getAttribute('data-date');
                    document.getElementById('modal-time').innerText = this.getAttribute('data-time');
                    document.getElementById('modal-number').innerText = this.getAttribute('data-number') + '人';
                    document.getElementById('modal-id').value = this.getAttribute('data-id');

                    // フォームのactionを動的に設定
                    document.querySelector('.delete-form').setAttribute('action', `/mypage/delete/${this.getAttribute('data-id')}`);

                    // モーダルを表示
                    modal.style.display = 'block';
                });
            });

            // モーダルを閉じる機能を追加
            document.querySelector('.modal-close__link').addEventListener('click', function(event) {
                event.preventDefault();  // デフォルトのリンク動作を無効化
                modal.style.display = 'none';  // モーダルを閉
            });

            // モーダルの外側をクリックしたときにモーダルを閉じる
            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
@endsection
