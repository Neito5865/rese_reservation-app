@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
    <div class="register__inner">
        <div class="register__heading">
            <h2>会員登録</h2>
        </div>
        <div class="form">
            <form method="POST" action="{{ route('register.store') }}" class="register-form">
                @csrf
                <input type="hidden" name="role" value="3">
                <div class="register-form__group">
                    <div class="register-form__item">
                        <div class="icon">
                            <i class="fa-solid fa-user" style="color: #4b4b4b;font-size: 25px;vertical-align: top;"></i>
                        </div>
                        <input type="text" class="register-form__item-input--name" name="name" value="{{ old('name') }}" placeholder="Username">
                    </div>
                    <div class="register-form__error">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="register-form__group">
                    <div class="register-form__item">
                        <div class="icon">
                            <i class="fa-solid fa-envelope" style="color: #4b4b4b;font-size: 25px;vertical-align: top;"></i>
                        </div>
                        <input type="email" class="register-form__item-input--email" name="email" value="{{ old('email') }}" placeholder="Email">
                    </div>
                    <div class="register-form__error">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="register-form__group">
                    <div class="register-form__item">
                        <div class="icon">
                            <i class="fa-solid fa-lock" style="color: #4b4b4b;font-size: 25px;vertical-align: top;"></i>
                        </div>
                        <input type="password" class="register-form__item-input--pass" name="password" placeholder="Password">
                    </div>
                    <div class="register-form__error">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="register-form__button">
                    <input type="submit" class="register-form__button-submit" value="登録">
                </div>
            </form>
        </div>
    </div>
@endsection
