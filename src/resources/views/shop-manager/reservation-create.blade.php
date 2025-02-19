@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/shop-manager/reservation-create.css') }}">
@endsection

@section('content')
    <div class="shopManagerReservation-create__content">
        @if(session('success'))
            <div class="shopManagerReservation-create__alert--success">
                {{ session('success') }}
            </div>
        @endif
        <div class="shopManagerReservation-create__heading">
            <h2>新規予約作成</h2>
        </div>
        <div class="shopManagerReservation-create__form">
            <form method="POST" action="{{ route('shopManagerReservation.store', $shop->id) }}" class="shopManagerReservation-create-form__content">
                @csrf
                <div class="shopManagerReservation-create-form__group">
                    <div class="shopManagerReservation-create-form__inner">
                        <label class="shopManagerReservation-create-form__label" for="shop_name">店名</label>
                        <input class="shopManagerReservation-create-form__input" id="shop_name" type="text" name="shop_name" value="{{ $shop->shop_name }}" readonly>
                    </div>
                </div>
                <div class="shopManagerReservation-create-form__group">
                    <div class="shopManagerReservation-create-form__inner">
                        <label class="shopManagerReservation-create-form__label" for="date">予約日</label>
                        <input class="shopManagerReservation-create-form__input" type="date" name="date" id="date" value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                    </div>
                    <div class="shopManagerReservation-create-form__error">
                        @error('date')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="shopManagerReservation-create-form__group">
                    <div class="shopManagerReservation-create-form__inner">
                        <label class="shopManagerReservation-create-form__label" for="time">予約時間</label>
                        <div class="shopManagerReservation-create-form__select">
                            <select class="shopManagerReservation-create-form__select--time" name="time" id="time">
                                @for ($i = 0; $i < 24 * 4; $i++ )
                                    @php
                                        $time = sprintf('%02d:%02d', intdiv($i, 4), ($i % 4) * 15);
                                    @endphp
                                    <option value="{{ $time }}" {{ $time == old('time', '12:00') ? 'selected' : '' }}>{{ $time }}</option>
                                @endfor
                            </select>
                            <i class="fa-solid fa-sort-down custom-arrow"></i>
                        </div>
                    </div>
                    <div class="shopManagerReservation-create-form__error">
                        @error('time')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="shopManagerReservation-create-form__group">
                    <div class="shopManagerReservation-create-form__inner">
                        <label class="shopManagerReservation-create-form__label" for="number_people">予約人数</label>
                        <div class="shopManagerReservation-create-form__select">
                            <select class="shopManagerReservation-create-form__select--number" name="number_people" id="number_people">
                                @for ($i = 1; $i <= 100; $i++ )
                                    <option value="{{ $i }}" {{ $i == old('number_people', '1') ? 'selected' : '' }}>{{ $i == 100 ? '100人〜' :$i . '人' }}</option>
                                @endfor
                            </select>
                            <i class="fa-solid fa-sort-down custom-arrow"></i>
                        </div>
                    </div>
                    <div class="shopManagerReservation-create-form__error">
                        @error('number_people')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="shopManagerReservation-create-form__group">
                    <div class="shopManagerReservation-create-form__inner">
                        <label class="shopManagerReservation-create-form__label" for="user">予約者</label>
                        <button class="shopManagerReservation-create-form__btn--userChoise" type="button" id="user">ユーザーを選択</button>
                    </div>
                    <p id="selectedUserName" class="shopManagerReservation-create-form__selected-user"></p>
                    <div class="shopManagerReservation-create-form__error">
                        @error('user_id')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="shopManagerReservation-create-form__btn">
                    <div class="shopManagerReservation-create-form__btn-link">
                        <a class="shopManagerReservation-create-form__btn-link--back" href="{{ route('shopManager.detail', $shop->id) }}">&lt; 戻る</a>
                    </div>
                    <div class="shopManagerReservation-create-form__btn-submit">
                        <input class="shopManagerReservation-create-form__btn-submit--create" type="submit" value="予約する">
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- モーダルウィンドウ --}}
    <div id="userModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>ユーザーを選択</h2>
            <div class="modal__userSearch">
                <input type="text" id="userSearch" placeholder="キーワード検索">
            </div>
            <div class="modal-userList">
                <table class="userList-table" id="userList">
                    <tr class="userList-table__row">
                        <th class="userList-table__header">名前</th>
                        <th class="userList-table__header">メールアドレス</th>
                    </tr>
                    @foreach($users as $user)
                        <tr class="userList-table__row" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                            <td class="userList-table__item">{{ $user->name }}</td>
                            <td class="userList-table__item">{{ $user->email }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // モーダル表示のための変数
            var modal = document.getElementById('userModal');
            var btn = document.getElementById('user');
            var span = document.getElementsByClassName('close')[0];
            var selectedUserNameDisplay = document.getElementById('selectedUserName'); // 追加した要素を取得

            // ユーザーリストの各行を取得
            var userListRows = document.querySelectorAll('#userList tr.userList-table__row:not(:first-child)'); // 修正箇所

            // ボタンをクリックするとモーダルを表示
            btn.onclick = function() {
                modal.style.display = 'block';
            }

            // モーダルの×をクリックすると閉じる
            span.onclick = function() {
                modal.style.display = 'none';
            }

            // モーダル外をクリックすると閉じる
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }

            // ユーザー検索機能
            document.getElementById('userSearch').addEventListener('input', function () {
                var searchValue = this.value.toLowerCase();
                userListRows.forEach(function (row) {
                    var userName = row.getAttribute('data-user-name') ? row.getAttribute('data-user-name').toLowerCase() : '';
                    var userEmailElement = row.querySelector('td:nth-child(2)');
                    var userEmail = userEmailElement ? userEmailElement.textContent.toLowerCase() : '';

                    if (userName.includes(searchValue) || userEmail.includes(searchValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // ユーザーをクリックして選択
            userListRows.forEach(function (row) {  // 修正箇所
                row.addEventListener('click', function () {
                    var userId = this.getAttribute('data-user-id');
                    var userName = this.getAttribute('data-user-name');

                    // ボタンのテキストを更新
                    document.getElementById('user').textContent = 'ユーザーを選択';

                    // 追加した要素にユーザー名を表示
                    selectedUserNameDisplay.textContent = `選択したユーザー: ${userName}`;

                    // 既に hidden input が存在する場合は削除
                    var existingInput = document.querySelector('input[name="user_id"]');
                    if (existingInput) {
                        existingInput.remove();
                    }

                    // hidden input フィールドを追加
                    var userInput = document.createElement('input');
                    userInput.setAttribute('type', 'hidden');
                    userInput.setAttribute('name', 'user_id');
                    userInput.setAttribute('value', userId);
                    document.querySelector('.shopManagerReservation-create-form__inner').appendChild(userInput);

                    // モーダルを閉じる
                    modal.style.display = 'none';
                });
            });
        });
    </script>
@endsection

