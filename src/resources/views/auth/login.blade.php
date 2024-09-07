@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
    <div class="login__content">
        <div class="login__inner">
            <div class="login__heading">
                <h2>Login</h2>
            </div>
            <div class="form">
                <form method="" action="" class="login-form">
                    @csrf
                    <div class="login-form__item">
                        <input type="text" class="login-form__item-input--email" name="email" value="{{ old('email') }}" placeholder="Email">
                    </div>
                    <div class="login-form__item">
                        <input type="password" class="login-form__item-input--pass" name="email" placeholder="Password">
                    </div>
                    <div class="login-form__button">
                        <input type="submit" class="login-form__button-submit" value="ログイン">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
