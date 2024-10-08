@extends('layouts.app')

@section('content')
    @include('commons.header')
    <div class="shopManager-detaile__error">
        <h2>{{ $message }}</h2>
        <p><a href="{{ route('admin.index') }}">店舗責任者一覧へ戻る</a></p>
    </div>
@endsection
