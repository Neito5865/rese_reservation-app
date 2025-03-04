@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/create.css') }}">
@endsection

@section('content')
    <div class="shopManager-create__content">
        @include('session_message.session_message')
        <div class="shopManager-create__heading">
            <h2>新規店舗代表者作成</h2>
        </div>
        <div class="shopManager-create__form">
            <form method="POST" action="{{ route('admin.shop-manager.store') }}" class="shopManager-create-form">
                @csrf
                <div class="shopManager-create-form__group">
                    <div class="shopManager-create-form__inner">
                        <label class="shopManager-create-form__label" for="name">名前</label>
                        <input class="shopManager-create-form__input" id="name" type="text" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="shopManager-create-form__error">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="shopManager-create-form__group">
                    <div class="shopManager-create-form__inner">
                        <label class="shopManager-create-form__label" for="email">メールアドレス</label>
                        <input class="shopManager-create-form__input" id="email" type="email" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="shopManager-create-form__error">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="shopManager-create-form__group">
                    <div class="shopManager-create-form__inner">
                        <label class="shopManager-create-form__label" for="password">パスワード</label>
                        <input class="shopManager-create-form__input" id="password" type="password" name="password">
                    </div>
                    <div class="shopManager-create-form__error">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="shopManager-create-form__btn">
                    <div class="shopManager-create-form__btn-link">
                        <a class="shopManager-create-form__btn-link--back" href="{{ route('admin.shop-manager.index') }}">&lt; 戻る</a>
                    </div>
                    <div class="shopManager-create-form__btn-submit">
                        <input class="shopManager-create-form__btn-submit--create" type="submit" value="登録する">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
