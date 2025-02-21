@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/errors/error-page.css') }}">
@endsection

@section('content')
    <div class="error-page__content">
        <h2 class="error__heading">{{ $message }}</h2>
        <button class="back__btn">
            <a href="{{ route('shop.index') }}">トップページへ戻る</a>
        </button>
    </div>
@endsection
