@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/payment/payment.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="payment__content">
        <div class="payment__heading">
            <h1>オンライン決済</h1>
        </div>
        @if (session('success'))
            <div class="payment__alert--success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="payment__alert--error">{{ session('error') }}</div>
        @endif
        <div class="payment__form">
            <form class="payment-form__content" action="">
                @csrf
                <div class="payment-form__group">
                    <div class="payment-form__group-inner">
                        <label class="payment-form__label" for="shop">店舗を選択</label>
                        <div class="payment-form__select">
                            <select class="payment-form__select--shopName" name="shop_id" id="shop">
                                <option value="">選択してください</option>
                                @foreach ($shops as $shop)
                                    <option value="{{ $shop->id }}" {{ old('shop_id') ? 'selected' : '' }}>{{ $shop->shopName }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-sort-down custom-arrow"></i>
                        </div>
                    </div>
                    <div class="payment-form__error">
                        @error('shop_id')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="payment-form__group">
                    <div class="payment-form__group-inner">
                        <label class="payment-form__label" for="amount">金額 (JPY): </label>
                        <input class="payment-form__input" type="number" name="amount" id="amount">
                    </div>
                    <div class="payment-form__error">
                        @error('shop_id')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="payment-form__group">
                    <div id="card-element"></div>
                </div>
                <div class="payment-form__btn">
                    <input class="payment-form__btn--submit" type="submit" value="決済を行う">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event){
            event.preventDefault();
            stripe.createToken(card).then(function(result){
                if (result.error) {
                    // エラー表示
                } else {
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.token.id);
                    form.appendChild(hiddenInput);

                    form.submit();
                }
            });
        });
    </script>
@endsection
