@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/review/review-index.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="reviews__header">
        <h2>レビュー投稿</h2>
    </div>
    <div class="reviews__container">
        @foreach($reservations as $reservation)
            <div class="review-card">
                <div class="card__heading">
                    <p class="shop-name">{{ $reservation->shop->shopName }}</p>
                </div>
                <div class="review-card__item">
                    <p>来店日時</p>
                    <span class="reservation_date">{{ \Carbon\Carbon::parse($reservation->date)->format('Y年m月d日') }}</span>
                    <span class="reservation_time">{{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}</span>
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
                    @if(!$reservation->review)
                        <a class="link__shop-review" href="{{ route('reviews.create', ['id' => $reservation->id]) }}">レビューを投稿する</a>
                    @else
                        <span class="link__shop-review desabled">レビューを投稿済み</span>
                    @endif
                </div>
            </div>
        @endforeach
        {{ $reservations->links() }}
    </div>
@endsection
