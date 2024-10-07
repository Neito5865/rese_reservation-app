@extends('layouts.app')

@section('content')
    @include('commons.header')
    <div class="shop-review__error">
        <h1>{{ $message }}</h1>
        <p><a href="{{ route('shops') }}">店舗一覧へ戻る</a></p>
    </div>
@endsection
