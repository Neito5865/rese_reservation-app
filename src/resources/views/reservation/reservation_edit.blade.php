@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/reservation/reservation_edit.css') }}">
@endsection

@section('content')
    <div class="reservation-edit__content">
        <div class="reservation-edit__heading">
            <h2>予約内容の変更</h2>
        </div>
        <div class="form">
            <form method="POST" action="{{ route('reservation.update', $reservation->id) }}" class="edit-form">
                @csrf
                @method('PUT')
                <table class="edit-table">
                    <tr class="edit-table__row">
                        <th class="edit-table__heading">
                            <label class="edit-form__label" for="shop_name">店名</label>
                        </th>
                        <td class="edit-table__item">
                            <input class="edit-form__input--shop_name" id="shop_name" type="text" name="shop_name" value="{{ $reservation->shop->shop_name }}" readonly>
                        </td>
                    </tr>
                    <tr class="edit-table__row">
                        <th class="edit-table__heading">
                            <label class="edit-form__label" for="date">予約日</label>
                        </th>
                        <td class="edit-table__item">
                            <input class="edit-form__input--date" id="date" type="date" name="date" value="{{ old('date', $reservation->date) }}">
                        </td>
                    </tr>
                    <tr class="edit-table__row--error">
                        <th></th>
                        <td class="edit-table__item--error">
                            @error('date')
                            {{ $message }}
                            @enderror
                        </td>
                    </tr>
                    <tr class="edit-table__row">
                        <th class="edit-table__heading">
                            <label class="edit-form__label" for="time">予約時間</label>
                        </th>
                        <td class="edit-table__item item__select">
                            <select class="edit-form__select--time" id="time" name="time">
                                @for ($i = 0; $i < 24 * 4; $i++ )
                                    @php
                                        $time = sprintf('%02d:%02d', intdiv($i, 4), ($i % 4) * 15);
                                        $reservationTime = \Carbon\Carbon::parse($reservation->time)->format('H:i')
                                    @endphp
                                    <option value="{{ $time }}" {{ $time == old('time', $reservationTime) ? 'selected' : '' }}>{{ $time }}</option>
                                @endfor
                            </select>
                            <i class="fa-solid fa-sort-down custom-arrow"></i>
                        </td>
                    </tr>
                    <tr class="edit-table__row--error">
                        <th></th>
                        <td class="edit-table__item--error">
                            @error('time')
                            {{ $message }}
                            @enderror
                        </td>
                    </tr>
                    <tr class="edit-table__row">
                        <th class="edit-table__heading">
                            <label class="edit-form__label" for="number_people">予約人数</label>
                        </th>
                        <td class="edit-table__item item__select">
                            <select class="edit-form__select--number" id="number_people" name="number_people">
                                @for ($i = 1; $i <= 100; $i++ )
                                    <option value="{{ $i }}" {{ old('number_people', $reservation->number_people) == $i ? 'selected' : '' }}>{{ $i == 100 ? '100人〜' :$i . '人' }}</option>
                                @endfor
                            </select>
                            <i class="fa-solid fa-sort-down custom-arrow"></i>
                        </td>
                    </tr>
                    <tr class="edit-table__row--error">
                        <th></th>
                        <td class="edit-table__item--error">
                            @error('number_people')
                            {{ $message }}
                            @enderror
                        </td>
                    </tr>
                </table>
                <div class="edit-form__button">
                    <div class="back-link">
                        <a class="edit-form__button--link" href="/mypage">&lt; 戻る</a>
                    </div>
                    <div class="edit-btn">
                        <input class="edit-form__button--submit" type="submit" value="変更する">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
