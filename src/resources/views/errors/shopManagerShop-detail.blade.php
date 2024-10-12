@extends('layouts.app')

@section('content')
    @include('commons.header')
    <div class="shop-detaile__error">
        <h2>{{ $message }}</h2>
        <p><a href="{{ route('shopManager.index') }}">店舗一覧へ戻る</a></p>
    </div>
@endsection
