@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="login__inner">
        <div class="login__heading">
            <h2>Login</h2>
        </div>
        <div class="form">
            <form method="" action="" class="login-form">
                @csrf
                    <div class="login-form__item">
                        <div class="icon">
                            <i class="fa-solid fa-envelope" style="color: #4b4b4b;font-size: 25px;vertical-align: top;"></i>
                        </div>
                        <input type="text" class="login-form__item-input--email" name="email" value="{{ old('email') }}" placeholder="Email">
                    </div>
                    <div class="login-form__item">
                        <div class="icon">
                            <i class="fa-solid fa-lock" style="color: #4b4b4b;font-size: 25px;vertical-align: top;"></i>
                        </div>
                        <input type="password" class="login-form__item-input--pass" name="email" placeholder="Password">
                    </div>
                    <div class="login-form__button">
                        <input type="submit" class="login-form__button-submit" value="ログイン">
                    </div>
            </form>
        </div>
    </div>
@endsection
