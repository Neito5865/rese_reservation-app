@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="mypage-content">
        <div class="user-name">
            <p>testさん</p>
        </div>
        <div class="mypage-left">
            <div class="reservation-status">
                <div class="reservation-status__title">
                    <h2>予約状況</h2>
                </div>
                <div class="reservation-status__container">

                </div>


            </div>
        </div>


        <div class="reservation-container">
            <div class="reservation__heading">
                <h3>予約1</h3>
            </div>
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
        </div>
    </div>
@endsection
