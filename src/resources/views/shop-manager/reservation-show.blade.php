@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/shop-manager/reservation-show.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="shopManagerReservation-show__container">
        <div class="shopManagerReservation-show__btn">
            <a class="shopManagerReservation-show__btn--Link-back" href="{{ route('shopManager.detail', ['id' => $shopManagerReservation->shop->id]) }}">&lt; 予約一覧に戻る</a>
        </div>
        <div class="header-deleteBtn--flex">
            <div class="shopManagerReservation-show__header">
                <h2>予約情報</h2>
            </div>
            <div class="shopManagerReservation-show__btn--modal">
                <a class="shopManagerReservation-show__link--delete modal-trigger" href="#modal" data-id="{{ $shopManagerReservation->id }}">
                    <i class="fa-solid fa-trash-can"></i> 予約をキャンセル
                </a>
            </div>
        </div>
        @if(session('success'))
            <div class="shopManagerReservation-show__alert--success">
                {{ session('success') }}
            </div>
        @endif
        <div class="shopManagerReservation-edit__form">
            <form class="shopManagerReservation-edit-form" action="{{ route('shopManagerReservation.update', $shopManagerReservation->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="shopManagerReservation-edit-table__wrapper">
                    <table class="shopManagerReservation-edit-table__content">
                        <tr class="shopManagerReservation-edit-table__row">
                            <th class="shopManagerReservation-edit-table__heading">店名</th>
                            <td class="shopManagerReservation-edit-table__item">
                                <input class="shopManagerReservation-edit-form__input" type="text" name="shopName" value="{{ old('shopName', $shopManagerReservation->shop->shopName) }}" readonly>
                            </td>
                        </tr>
                        <tr class="shopManagerReservation-edit-table__row">
                            <th class="shopManagerReservation-edit-table__heading">予約日</th>
                            <td class="shopManagerReservation-edit-table__item">
                                <input class="shopManagerReservation-edit-form__input" type="date" name="date" value="{{ old('date', $shopManagerReservation->date) }}">
                            </td>
                        </tr>
                        <tr class="shopManagerReservation-edit-table__row--error">
                            <th></th>
                            <td class="shopManagerReservation-edit-table__item--error">
                                @error('date')
                                {{ $message }}
                                @enderror
                            </td>
                        </tr>
                        <tr class="shopManagerReservation-edit-table__row">
                            <th class="shopManagerReservation-edit-table__heading">予約時間</th>
                            <td class="shopManagerReservation-edit-table__item">
                                <div class="shopManagerReservation-edit-form__select">
                                    <select class="shopManagerReservation-edit-form__select--time" name="time">
                                        @for ($i = 0; $i < 24 * 4; $i++ )
                                            @php
                                                $time = sprintf('%02d:%02d', intdiv($i, 4), ($i % 4) * 15);
                                                $reservationTime = \Carbon\Carbon::parse($shopManagerReservation->time)->format('H:i')
                                            @endphp
                                            <option value="{{ $time }}" {{ $time == old('time', $reservationTime) ? 'selected' : '' }}>{{ $time }}</option>
                                        @endfor
                                    </select>
                                    <i class="fa-solid fa-sort-down custom-arrow-time"></i>
                                </div>
                            </td>
                        </tr>
                        <tr class="shopManagerReservation-edit-table__row--error">
                            <th></th>
                            <td class="shopManagerReservation-edit-table__item--error">
                                @error('time')
                                {{ $message }}
                                @enderror
                            </td>
                        </tr>
                        <tr class="shopManagerReservation-edit-table__row">
                            <th class="shopManagerReservation-edit-table__heading">予約人数</th>
                            <td class="shopManagerReservation-edit-table__item">
                                <div class="shopManagerReservation-edit-form__select">
                                    <select class="shopManagerReservation-edit-form__select--number" name="numberPeople">
                                        @for ($i = 1; $i <= 100; $i++ )
                                            <option value="{{ $i }}" {{ old('numberPeople', $shopManagerReservation->numberPeople) == $i ? 'selected' : '' }}>{{ $i == 100 ? '100人〜' :$i . '人' }}</option>
                                        @endfor
                                    </select>
                                    <i class="fa-solid fa-sort-down custom-arrow-number"></i>
                                </div>
                            </td>
                        </tr>
                        <tr class="shopManagerReservation-edit-table__row--error">
                            <th></th>
                            <td class="shopManagerReservation-edit-table__item--error">
                                @error('numberPeople')
                                {{ $message }}
                                @enderror
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="shopManagerReservation-edit-form__btn">
                    <input type="submit" class="shopManagerReservation-edit-form__btn--submit" value="予約変更">
                </div>
            </form>
        </div>
    </div>
    <div class="user-detail__container">
        <div class="user-detail__header">
            <h2>予約者情報</h2>
        </div>
        <div class="user-detail-table">
            <table class="user-detail-table__content">
                <tr class="user-detail-table__row">
                    <th class="user-detail-table__heading">ユーザー名</th>
                    <td class="user-detail-table__item">
                        {{ $shopManagerReservation->user->name }}
                    </td>
                </tr>
                <tr class="user-detail-table__row">
                    <th class="user-detail-table__heading">メールアドレス</th>
                    <td class="user-detail-table__item">
                        {{ $shopManagerReservation->user->email }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="modal" class="modal">
        <div class="modal__contents">
            <div class="modal-close">
                <a class="modal-close__link" href="#">&times;</a>
            </div>
            <div class="modal__content">
                <div class="modal__message">
                    <h2>予約をキャンセルしてもよろしいですか？</h2>
                </div>
                <div class="delete-form">
                    <form class="delete-form__content" action="" method="POST">
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
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            // 「予約をキャンセル」リンクを取得
            var deleteLink = document.querySelector('.modal-trigger');

            // モーダルと関連要素を取得
            var modal = document.getElementById('modal');
            var closeModalLink = document.querySelector('.modal-close__link');
            var modalForm = document.querySelector('.delete-form__content');
            var modalIdInput = document.getElementById('modal-id');

            // キャンセルリンクにクリックイベントを追加
            if(deleteLink){
                deleteLink.addEventListener('click', function(event){
                    event.preventDefault();
                    var reservationId = this.getAttribute('data-id');

                    // フォームのaction URLを更新
                    modalForm.setAttribute('action', `/shop-manager/reservations/${reservationId}/delete`);

                    // hidden inputに予約IDをセット
                    modalIdInput.value = reservationId;

                    // モーダルを表示
                    modal.style.display = 'block';
                });
            }

            // モーダルを閉じるイベント
            if(closeModalLink){
                closeModalLink.addEventListener('click', function(event){
                    event.preventDefault();
                    modal.style.display = 'none';
                });
            }

            // モーダル枠外をクリックした時にモーダルを閉じる
            window.addEventListener('click', function(event){
                if(event.target == modal){
                    modal.style.display = 'none';
                }
            });
        })
    </script>
@endsection