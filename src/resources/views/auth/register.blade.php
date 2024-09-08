@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
    <div class="register__content">
        <div class="register__inner">
            <div class="register__heading">
                <h2>Register</h2>
            </div>
            <div class="form">
                <form method="" action="" class="register-form">
                    @csrf
                        <div class="register-form__item">
                            <div class="icon">
                                <i class="fa-solid fa-user" style="color: #4b4b4b;font-size: 25px;vertical-align: top;"></i>
                            </div>
                            <input type="text" class="register-form__item-input--name" name="name" value="{{ old('name') }}" placeholder="Username">
                        </div>
                        <div class="register-form__item">
                            <div class="icon">
                                <i class="fa-solid fa-envelope" style="color: #4b4b4b;font-size: 25px;vertical-align: top;"></i>
                            </div>
                            <input type="email" class="register-form__item-input--email" name="email" value="{{ old('email') }}" placeholder="Email">
                        </div>
                        <div class="register-form__item">
                            <div class="icon">
                                <i class="fa-solid fa-lock" style="color: #4b4b4b;font-size: 25px;vertical-align: top;"></i>
                            </div>
                            <input type="password" class="register-form__item-input--pass" name="email" placeholder="Password">
                        </div>
                        <div class="register-form__button">
                            <input type="submit" class="register-form__button-submit" value="登録">
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
