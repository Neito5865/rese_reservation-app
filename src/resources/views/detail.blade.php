@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <div class="content-flex">
        <div class="content-left">
            @include('commons.header')
            <div class="detail-container">
                <div class="detail__heading">
                    <button class="back-button"><a href="/">&lt;</a></button>
                    <h2 class="detail__shop-name">仙人</h2>
                </div>
                <div class="detail__img">
                    <img src="https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg" alt="仙人">
                </div>
                <div class="detail__tag">
                    <span class="detail__tag--area">#東京都</span>
                    <span class="detail__tag--genre">#寿司</span>
                </div>
                <div class="detail__description">
                    <p>料理長厳選の食材から作る寿司を用いたコースをぜひお楽しみください。食材・味・価格、お客様の満足度を徹底的に追及したお店です。特別な日のお食事、ビジネス接待まで気軽に使用することができます。</p>
                </div>
            </div>
        </div>

        <div class="content-right">
            <div class="reservation-container">
                <div class="reservation__heading">
                    <h2>予約</h2>
                </div>
                <div class="form">
                    <form method="" action="" class="reservation-form">
                    @csrf
                        <input class="reservation-form__input" type="date" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        <select class="reservation-form__select" name="number">
                            @for ($i = 0; $i < 24 * 4; $i++ )
                                @php
                                    $time = sprintf('%02d:%02d', intdiv($i, 4), ($i % 4) * 15);
                                @endphp
                                <option value="{{ $time }}" {{ $time == '12:00' ? 'selected' : '' }}>{{ $time }}</optioin>
                            @endfor
                        </select>
                        <select class="reservation-form__select" name="number">
                            @for ($i = 1; $i <= 100; $i++ )
                                <option value="{{ $i }}" {{ $i == '1' ? 'selected' : '' }}>{{ $i == 100 ? '100人〜' :$i . '人' }}</optioin>
                            @endfor
                        </select>
                        <div class="reservation-summary">
                            <table class="reservation-summary-table">
                                <tr class="reservation-summary-table__row">
                                    <th class="reservation-summary-table__heading">Shop</th>
                                    <td class="reservation-summary-table__item">仙人</td>
                                </tr>
                                <tr class="reservation-summary-table__row">
                                    <th class="reservation-summary-table__heading">Date</th>
                                    <td class="reservation-summary-table__item">2024-09-11</td>
                                </tr>
                                <tr class="reservation-summary-table__row">
                                    <th class="reservation-summary-table__heading">Time</th>
                                    <td class="reservation-summary-table__item">17:00</td>
                                </tr>
                                <tr class="reservation-summary-table__row">
                                    <th class="reservation-summary-table__heading">Number</th>
                                    <td class="reservation-summary-table__item">1人</td>
                                </tr>
                            </table>
                        </div>
                        <div class="reservation-form__button">
                            <input class="reservation-form__button--submit" type="submit" value="予約する">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
