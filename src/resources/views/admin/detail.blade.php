@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/detail.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="shopManager-detail__container">
        <div class="shopManager-detail__header">
            <h2>基本情報</h2>
        </div>
        <div class="shopManager-detail-card">

        </div>
    </div>
    <div class="shopManager-shopList__container">
        <div class="shopManager-shopList__header">
            <h2>店舗一覧</h2>
        </div>
        <div class="shopManager-shopList-table">
        </div>
    </div>
@endsection
