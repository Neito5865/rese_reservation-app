@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/qr-result.css') }}">
@endsection

@section('content')
    <div class="qr-result__content">
        <div class="qr-result__heading">
            <h1>{{ $reservation->user->name }}様の予約内容</h1>
        </div>
        <div class="reservation-detail__content">
            <ul>
                <li>店名: {{ $reservation->shop->shopName }}</li>
                <li>日付: {{ $reservation->date }}</li>
                <li>時間: {{ $reservation->time }}</li>
                <li>人数: {{ $reservation->numberPeople }}人</li>
            </ul>
        </div>
    </div>
@endsection
