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
            <form id="payment-form" class="payment-form__content" action="{{ route('payment.process') }}" method="POST">
                @csrf
                <div class="payment-form__group">
                    <div class="payment-form__group-inner">
                        <label class="payment-form__label" for="shop">店舗を選択</label>
                        <div class="payment-form__select">
                            <select class="payment-form__select--shopName" name="shop_id" id="shop">
                                <option value="">選択してください</option>
                                @foreach ($shops as $shop)
                                    <option value="{{ $shop->id }}" {{ old('shop_id') == $shop->id ? 'selected' : '' }}>{{ $shop->shopName }}</option>
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
                        <label class="payment-form__label" for="amount">金額を入力</label>
                        <input class="payment-form__input" type="number" name="amount" id="amount" value="{{ old('amount') }}">
                    </div>
                    <div class="payment-form__error">
                        @error('amount')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="payment-card-form__content">
                    <div class="payment-card-form__heading">
                        <p>カード情報を入力</p>
                    </div>
                    <div class="payment-form__group">
                        <div class="payment-form__group-inner">
                            <label class="payment-form__label" for="card_number">カード番号</label>
                            <div id="card-number" class="payment-form__card-form"></div>
                        </div>
                    </div>
                    <div class="payment-form__group">
                        <div class="payment-form__group-inner">
                            <label class="payment-form__label" for="card_expiry">有効期限</label>
                            <div id="card-expiry" class="payment-form__card-form"></div>
                        </div>
                    </div>
                    <div class="payment-form__group">
                        <div class="payment-form__group-inner">
                            <label class="payment-form__label" for="card_cvc">セキュリティコード</label>
                            <div id="card-cvc" class="payment-form__card-form"></div>
                        </div>
                    </div>
                    <div id="card-errors" class="payment-card-form__error"></div>
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

        var style = {
            base: {
                color: '#32325d',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
            }
        };

        var cardNumber = elements.create('cardNumber', {style: style});
        cardNumber.mount('#card-number');
        cardNumber.on('change', function(event){
            var displayError = document.getElementById('card-errors');
            if (event.error){
                if (event.error.code === 'incomplete_number'){
                    displayError.textContent = 'カード番号を入力してください';
                } else if (event.error.code === 'invalid_number'){
                    displayError.textContent = 'カード番号が無効です';
                } else {
                    displayError.textContent = event.error.message;
                }
            } else {
                displayError.textContent = '';
            }
        });

        var cardExpiry = elements.create('cardExpiry', {style: style});
        cardExpiry.mount('#card-expiry');
        cardExpiry.on('change', function(event){
            var displayError = document.getElementById('card-errors');
            if (event.error){
                if (event.error.code === 'incomplete_expiry'){
                    displayError.textContent = '有効期限を入力してください';
                } else if (event.error.code === 'invalid_expiry_month_past'){
                    displayError.textContent = '有効期限の月が無効です';
                } else {
                    displayError.textContent = event.error.message;
                }
            } else {
                displayError.textContent = '';
            }
        });

        var cardCvc = elements.create('cardCvc', {style: style});
        cardCvc.mount('#card-cvc');
        cardCvc.on('change', function(event){
            var displayError = document.getElementById('card-errors');
            if (event.error){
                if (event.error.code === 'incomplete_cvc'){
                    displayError.textContent = 'セキュリティコードを入力してください';
                } else if (event.error.code === 'invalid_cvc'){
                    displayError.textContent = 'セキュリティコードが無効です';
                } else {
                    displayError.textContent = event.error.message;
                }
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event){
            event.preventDefault();

            stripe.createToken(cardNumber).then(function(result){
                if (result.error) {
                    // エラー表示
                    var displayError = document.getElementById('card-errors');

                    var errorMessage = result.error.message;

                    if (errorMessage.includes('Your card was declined')) {
                        errorMessage = 'カードが拒否されました。別のカードを試してください。';
                    } else if (errorMessage.includes('Your card has expired')) {
                        errorMessage = 'カードの有効期限が切れています。';
                    } else if (errorMessage.includes('Your card number is incorrect')) {
                        errorMessage = 'カード番号が間違っています。';
                    }
                    displayError.textContent = errorMessage;
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
