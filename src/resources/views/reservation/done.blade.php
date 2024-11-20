@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/reservation/done.css') }}">
@endsection

@section('content')
    <div class="done__inner">
        <div class="done__heading">
            <h2>ご予約ありがとうございます</h2>
        </div>
        <div class="done__button">
            <a href="/" class="done__button--link">戻る</a>
        </div>
    </div>
@endsection
