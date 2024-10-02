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
        <div class="review-card">
            <div class="card__heading">
                <p class="shop-name">店名</p>
            </div>
            <div class="review-card__item">
                <p>来店日時</p>
                <span class="reservation_date">2024年10月1日</span>
                <span class="reservation_time">12:00</span>
            </div>
            <div class="review-card__item">
                <p class="review-status__heading">投稿状況</p>
                <span class="review-status">未投稿</span>
            </div>
            <div class="review-card__link">
                <a class="link__shop-detail" href="">店舗詳細</a>
                <a href="link__shop-review">口コミを投稿する</a>
            </div>
        </div>
        <div class="review-card">
            <div class="card__heading">
                <p class="shop-name">店名</p>
            </div>
            <div class="review-card__item">
                <p>来店日時</p>
                <span class="reservation_date">2024年10月1日</span>
                <span class="reservation_time">12:00</span>
            </div>
            <div class="review-card__item">
                <p class="review-status__heading">投稿状況</p>
                <span class="review-status">未投稿</span>
            </div>
            <div class="review-card__link">
                <a class="link__shop-detail" href="">店舗詳細</a>
                <a href="link__shop-review">口コミを投稿する</a>
            </div>
        </div>
@endsection
