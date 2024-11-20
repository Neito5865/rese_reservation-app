@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
    <div class="login__inner">
        <div class="login__heading">
            <h2>ログイン</h2>
        </div>
        <div class="form">
            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                    <div class="login-form__group">
                        <div class="login-form__item">
                            <div class="icon">
                                <i class="fa-solid fa-envelope" style="color: #4b4b4b;font-size: 25px;vertical-align: top;"></i>
                            </div>
                            <input type="text" class="login-form__item-input--email" name="email" value="{{ old('email') }}" placeholder="Email">
                        </div>
                        <div class="login-form__error">
                            @error('email')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="login-form__group">
                        <div class="login-form__item">
                            <div class="icon">
                                <i class="fa-solid fa-lock" style="color: #4b4b4b;font-size: 25px;vertical-align: top;"></i>
                            </div>
                            <input type="password" class="login-form__item-input--pass" name="password" placeholder="Password">
                        </div>
                        <div class="login-form__error">
                            @error('password')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="login-form__button">
                        <input type="submit" class="login-form__button-submit" value="ログイン">
                    </div>
            </form>
        </div>
    </div>
@endsection
