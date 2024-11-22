@extends('layouts.app')

@section('content')
    <div class="shop-review__error">
        <h2>{{ $message }}</h2>
        <p><a href="{{ route('shops') }}">店舗一覧へ戻る</a></p>
    </div>
@endsection
