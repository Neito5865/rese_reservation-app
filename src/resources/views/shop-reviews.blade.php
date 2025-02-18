@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/shop-reviews.css') }}">
@endsection

@section('content')
    <div class="shop-reviews__header">
        <h2>{{ $shop->shop_name }} のレビュー</h2>
    </div>
    <div class="shop-reviews__container">
        <div class="shop-reviews__back">
            <a class="shop-reviews__back--link" href="{{ route('shop.detail', $shop->id) }}">&lt; 店舗詳細に戻る</a>
        </div>
        @foreach($reviews as $review)
            <div class="shop-reviews-card">
                <div class="shop-reviews-card__name">
                    @if ($review->is_anonymous == 1)
                        投稿者さん
                    @else
                        {{ $review->user->name }}
                    @endif
                </div>
                <div class="shop-reviews-card__rating">
                    <p>評価</p>
                    <div class="rating">
                        <div class="stars-outer">
                            <div class="stars-inner" style="width: {{ ($review->evaluation / 5) * 100 }}%;"></div>
                        </div>
                        <span class="rating-number">{{ number_format($review->evaluation, 0) }}</span>
                    </div>
                </div>
                <div class="shop-reviews-card__comment">
                    <p class="comment__visit-date">来店日：{{ $review->reservation->date }}</p>
                    <p class="comment__content">{!! nl2br(e($review->comment)) !!}</p>
                </div>
            </div>
        @endforeach
        <div class="shop-review__paginate">
            {{ $reviews->links() }}
        </div>
    </div>
@endsection
