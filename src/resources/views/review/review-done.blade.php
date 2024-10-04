@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/review/review-done.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="review-done__inner">
        <div class="review-done__heading">
            <h2>レビューの投稿が完了しました</h2>
        </div>
        <div class="review-done__button">
            <a href="{{ route('mypage.show') }}" class="review-done__button--link">戻る</a>
        </div>
    </div>
@endsection
