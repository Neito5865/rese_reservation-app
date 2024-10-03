@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/review/review-index.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="reviews__header">
        <h1>口コミ投稿</h1>
    </div>
    <div class="reviews__container">
        @foreach($reservations as $reservation)
            <div class="review-card">
                <div class="card__heading">
                    <p class="shop-name">{{ optional($reservation->shop)->shopName }}</p>
                </div>
                <div class="review-card__item">
                    <p>来店日時</p>
                    <span class="reservation_date">{{ $reservation->date }}</span>
                    <span class="reservation_time">{{ $reservation->time }}</span>
                </div>
                <div class="review-card__item">
                    <p class="review-status__heading">投稿状況</p>
                    @if(!$reservation->review)
                        <span class="review-status">未投稿</span>
                    @else
                        <span class="review-status">投稿済み</span>
                    @endif
                </div>
                <div class="review-card__link">
                    <a class="link__shop-detail" href="{{ route('shop.detail', ['shop_id' => $reservation->shop->id]) }}">店舗詳細</a>
                    <a class="link__shop-review" href="{{ route('reviews.create', ['reservation => $reservation->id']) }}">口コミを投稿する</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
