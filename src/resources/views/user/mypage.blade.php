@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="mypage-container">
        @include('session_message.session_message')
        <div class="mypage__user-name">
            <p>{{ Auth::user()->name }}さん</p>
        </div>
        <div class="mypage__flex">
            <div class="mypage-left">
                <div class="reservation-status">
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
                                            data-shop="{{ $reservation->shop->shop_name }}"
                                            data-date="{{ $reservation->date }}"
                                            data-time="{{\Carbon\Carbon::parse($reservation->time)->format('H:i')}}"
                                            data-number="{{ $reservation->number_people }}">
                                            &times;
                                        </a>
                                    </div>
                                </div>
                                <table class="status-card-table">
                                    <tr class="status-card-table__row">
                                        <th class="status-card-table__heading">Shop</th>
                                        <td class="status-card-table__item">{{ $reservation->shop->shop_name }}</td>
                                    </tr>
                                    <tr class="status-card-table__row">
                                        <th class="status-card-table__heading">Date</th>
                                        <td class="status-card-table__item">{{ $reservation->date }}</td>
                                    </tr>
                                    <tr class="status-card-table__row">
                                        <th class="status-card-table__heading">Time</th>
                                        <td class="status-card-table__item">{{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}</td>
                                    </tr>
                                    <tr class="status-card-table__row">
                                        <th class="status-card-table__heading">Number</th>
                                        <td class="status-card-table__item">{{ $reservation->number_people }}人</td>
                                    </tr>
                                </table>
                                <div class="status-card__edit-btn">
                                    <a class="status-card__edit-btn--link" href="{{ route('reservation.edit', $reservation->id) }}">予約内容の変更</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="review-btn">
                    <a class="review-btn__link" href="{{ route('review.index') }}">過去の利用店舗のレビューを投稿する<i class="fa-solid fa-circle-chevron-right"></i></a>
                </div>
            </div>
            <div class="mypage-right">
                <div class="favorite-shops__title">
                    <h2>お気に入り店舗</h2>
                </div>
                <div class="favorite-card__flex">
                    @foreach($favoriteShops as $shop)
                        <div class="favorite-card">
                            <div class="favorite-card__img">
                                <img src="{{ asset('storage/' . $shop->shop_img) }}" alt="{{ $shop->shop_name }}">
                            </div>
                            <div class="favorite-card__content">
                                <h3 class="favorite-card__shop-name">{{ $shop->shop_name }}</h3>
                                <div class="favorite-card__tag">
                                    <span class="favorite-card__tag--area">#{{ $shop->area->prefecture }}</span>
                                    <span class="favorite-card__tag--genre">#{{ $shop->genre->content }}</span>
                                </div>
                                <div class="favorite-card__content--flex">
                                    <div class="favorite-card__link">
                                        <a href="{{ route('shop.detail', $shop->id) }}" class="favorite-card__link-detail">詳しくみる</a>
                                    </div>
                                    @if(Auth::check())
                                        @if(Auth::user()->isFavorite($shop->id))
                                            <form class="favorite-card__form" method="POST" action="{{ route('unfavorite', $shop->id) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button class="favorite-card__btn--favorite favorited" type="submit"><i class="fa-solid fa-heart"></i></button>
                                            </form>
                                        @else
                                            <form class="favorite-card__form" method="POST" action="{{ route('favorite', $shop->id) }}">
                                                @csrf
                                                <button class="favorite-card__btn--favorite" type="submit"><i class="fa-solid fa-heart"></i></button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                        <a class="modal-close__back--link" href="{{ route('mypage.show') }}">&lt; 戻る</a>
                    </div>
                    <form class="delete-form" action="" method="POST">
                        @method('DELETE')
                        @csrf
                        <div class="delete-form__button">
                            <input type="hidden" name="id" id="modal-id" value="">
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
            var modal = document.getElementById('modal');
            modalTriggers.forEach(function(trigger) {
                trigger.addEventListener('click', function(event) {
                    event.preventDefault();

                    document.getElementById('modal-shop').innerText = this.getAttribute('data-shop');
                    document.getElementById('modal-date').innerText = this.getAttribute('data-date');
                    document.getElementById('modal-time').innerText = this.getAttribute('data-time');
                    document.getElementById('modal-number').innerText = this.getAttribute('data-number') + '人';
                    document.getElementById('modal-id').value = this.getAttribute('data-id');

                    var reservationId = this.getAttribute('data-id');
                    document.querySelector('.delete-form').setAttribute('action', `/reservation/${reservationId}/delete`);

                    modal.style.display = 'block';
                });
            });

            document.querySelector('.modal-close__link').addEventListener('click', function(event) {
                event.preventDefault();
                modal.style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
@endsection
