@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/thanks.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="thanks__inner">
        <div class="thanks__heading">
            <h2>会員登録ありがとうございます</h2>
        </div>
        <div class="thanks__button">
            <a href="/login" class="thanks__button--link">ログインする</a>
        </div>
    </div>
@endsection