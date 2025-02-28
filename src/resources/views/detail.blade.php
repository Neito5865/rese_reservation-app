@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <div class="content-flex">
        <div class="content-left">
            <div class="detail-container">
                <div class="detail__heading">
                    <button class="back-button"><a href="{{ route('shop.index') }}">&lt;</a></button>
                    <h2 class="detail__shop-name">{{ $shop->shop_name }}</h2>
                </div>
                <div class="detail__img">
                    <img src="{{ asset('storage/' . $shop->shop_img) }}" alt="{{ $shop->shop_name }}">
                </div>
                <div class="detail__tag">
                    <span class="detail__tag--area">#{{ $shop->area->prefecture }}</span>
                    <span class="detail__tag--genre">#{{ $shop->genre->content }}</span>
                </div>
                <div class="detail__description">
                    <p>{{ $shop->detail }}</p>
                </div>
            </div>
            <div class="detail-review__container">
                <div class="detail-review__heading">
                    <h2 class="detail-review__title">お店のレビュー</h2>
                </div>
                <div class="detail-review__average">
                    <p>評価平均</p>
                    <div class="rating">
                        <div class="stars-outer">
                            <div class="stars-inner" style="width: {{ ($averageRating / 5) * 100 }}%;"></div>
                        </div>
                        <span class="average-rating-number">{{ number_format($averageRating, 2) }}</span>
                    </div>
                </div>
                <div class="detail-review__link">
                    <a class="detail-review__link--all-review" href="{{ route('shop.reviews', $shop->id) }}"><i class="fa-regular fa-comments"></i>全てのレビューを見る （{{$reviewCount}}件）</a>
                </div>
            </div>
        </div>

        <div class="content-right">
            <div class="reservation-container">
                <div class="reservation__heading">
                    <h2>予約</h2>
                </div>
                <div class="form">
                    <form method="POST" action="{{ route('reservation.store', $shop->id) }}" class="reservation-form">
                    @csrf
                        <input class="reservation-form__input" type="date" name="date" value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                        <div class="reservation-form__error">
                            @error('date')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="reservation-form__select">
                            <select class="reservation-form__select--time" name="time">
                                @for ($i = 0; $i < 24 * 4; $i++ )
                                    @php
                                        $time = sprintf('%02d:%02d', intdiv($i, 4), ($i % 4) * 15);
                                    @endphp
                                    <option value="{{ $time }}" {{ $time == old('time', '12:00') ? 'selected' : '' }}>{{ $time }}</option>
                                @endfor
                            </select>
                            <i class="fa-solid fa-sort-down custom-arrow"></i>
                        </div>
                        <div class="reservation-form__error">
                            @error('time')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="reservation-form__select">
                            <select class="reservation-form__select--number" name="number_people">
                                @for ($i = 1; $i <= 100; $i++ )
                                    <option value="{{ $i }}" {{ $i == old('number_people', '1') ? 'selected' : '' }}>{{ $i == 100 ? '100人〜' :$i . '人' }}</option>
                                @endfor
                            </select>
                            <i class="fa-solid fa-sort-down custom-arrow"></i>
                        </div>
                        <div class="reservation-form__error">
                            @error('number_people')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="reservation-summary">
                            @if(Auth::check())
                                @if ($userReservations->isEmpty())
                                    @can('admin-higher')
                                        <p>管理者ユーザーは予約できません。</p>
                                    @elsecan('shopManager-higher')
                                        <p>店舗代表者ユーザーは予約できません。</p>
                                    @elsecan('user-higher')
                                        <p>現在、この店舗での予約はありません。</p>
                                    @endcan
                                @else
                                    @foreach($userReservations as $reservation)
                                        <table class="reservation-summary-table">
                                            <tr class="reservation-summary-table__row">
                                                <th class="reservation-summary-table__heading">Shop</th>
                                                <td class="reservation-summary-table__item">{{ $reservation->shop->shop_name }}</td>
                                            </tr>
                                            <tr class="reservation-summary-table__row">
                                                <th class="reservation-summary-table__heading">Date</th>
                                                <td class="reservation-summary-table__item">{{ $reservation->date }}</td>
                                            </tr>
                                            <tr class="reservation-summary-table__row">
                                                <th class="reservation-summary-table__heading">Time</th>
                                                <td class="reservation-summary-table__item">{{\Carbon\Carbon::parse($reservation->time)->format('H:i')}}</td>
                                            </tr>
                                            <tr class="reservation-summary-table__row">
                                                <th class="reservation-summary-table__heading">Number</th>
                                                <td class="reservation-summary-table__item">{{ $reservation->number_people }}人</td>
                                            </tr>
                                        </table>
                                    @endforeach
                                @endif
                            @else
                                <p>この店舗での予約状況を確認するには<br>ログインしてください。</p>
                            @endif
                        </div>
                        <div class="reservation-form__button">
                            @if(Auth::check())
                                @can('admin-higher')
                                @elsecan('shopManager-higher')
                                @elsecan('user-higher')
                                    <button class="reservation-form__button--submit" type="submit">予約する</button>
                                @endcan
                            @else
                                <button class="reservation-form__button--submit" type="submit">予約する</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
