@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/shop_manager/send_email/send-email.css') }}">
@endsection

@section('content')
    <div class="sendUserMail__content">
        <div class="sendUserMail__btn">
            <a class="sendUserMail__btn--link-back" href="{{ route('shop-manager.reservation.show',  $reservation->id) }}">&lt; 予約情報に戻る</a>
        </div>
        @include('session_message.session_message')
        <div class="sendUserMail__heading">
            <h2>メール送信フォーム</h2>
        </div>
        <div class="sendUserMail__form">
            <form class="sendUserMail-form__content" action="{{ route('shop-manager.send-mail.send') }}" method="POST">
                @csrf
                <div class="sendUserMail-form__group">
                    <label class="sendUserMail-form__label" for="to">
                        <span class="sendUserMail-form__label--heading">宛先</span>
                        <span class="sendUserMail-form__label--required">必須</span>
                    </label>
                    <div class="sendUserMail-form__input">
                        <input class="sendUserMail-form__input-email" type="email" id="to" name="to" value="{{ old('email', $user->email) }}">
                    </div>
                </div>
                <div class="sendUserMail-form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
                <div class="sendUserMail-form__group">
                    <label class="sendUserMail-form__label" for="subject">
                        <span class="sendUserMail-form__label--heading">件名</span>
                        <span class="sendUserMail-form__label--required">必須</span>
                    </label>
                    <div class="sendUserMail-form__input">
                        <input class="sendUserMail-form__input-subject" type="text" id="subject" name="subject" value="{{ old('subject') }}">
                    </div>
                </div>
                <div class="sendUserMail-form__error">
                    @error('subject')
                    {{ $message }}
                    @enderror
                </div>
                <div class="sendUserMail-form__group">
                    <label class="sendUserMail-form__label" for="message">
                        <span class="sendUserMail-form__label--heading">本文</span>
                        <span class="sendUserMail-form__label--required">必須</span>
                    </label>
                    <div class="sendUserMail-form__textarea">
                        <textarea class="sendUserMail-form__textarea-message" name="message" id="message"></textarea>
                    </div>
                </div>
                <div class="sendUserMail-form__error">
                    @error('message')
                    {{ $message }}
                    @enderror
                </div>
                <div class="sendUserMail-form__button">
                    <input class="sendUserMail-form__button--submit" type="submit" value="メールを送信">
                </div>
            </form>
        </div>
    </div>
@endsection
