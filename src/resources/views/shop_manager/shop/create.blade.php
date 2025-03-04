@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/shop_manager/shop/create.css') }}">
@endsection

@section('content')
    <div class="shopManagerShop-create__content">
        @include('session_message.session_message')
        <div class="shopManagerShop-create__heading">
            <h2>新規店舗作成</h2>
        </div>
        <div class="shopManagerShop-create__form">
            <form method="POST" action="{{ route('shop-manager.shop.store') }}" class="shopManagerShop-create-form" enctype="multipart/form-data">
                @csrf
                <div class="shopManagerShop-create-form__group">
                    <div class="shopManagerShop-create-form__inner">
                        <label class="shopManagerShop-create-form__label" for="shop_name">店名</label>
                        <input class="shopManagerShop-create-form__input" id="shop_name" type="text" name="shop_name" value="{{ old('shop_name') }}">
                    </div>
                    <div class="shopManagerShop-create-form__error">
                        @error('shop_name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="shopManagerShop-create-form__group">
                    <div class="shopManagerShop-create-form__inner">
                        <label class="shopManagerShop-create-form__label" for="area">エリア</label>
                        <div class="shopManagerShop-create-form__select">
                            <select name="area_id" id="area" class="shopManagerShop-create-form__select--area">
                                <option value="">選択してください</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->prefecture }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-sort-down custom-arrow-area"></i>
                        </div>
                    </div>
                    <div class="shopManagerShop-create-form__error">
                        @error('area_id')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="shopManagerShop-create-form__group">
                    <div class="shopManagerShop-create-form__inner">
                        <label class="shopManagerShop-create-form__label" for="genre">ジャンル</label>
                        <div class="shopManagerShop-create-form__select">
                            <select name="genre_id" id="genre" class="shopManagerShop-create-form__select--genre">
                                <option value="">選択してください</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>{{ $genre->content }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-sort-down custom-arrow-genre"></i>
                        </div>
                    </div>
                    <div class="shopManagerShop-create-form__error">
                        @error('genre_id')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="shopManagerShop-create-form__group">
                    <div class="shopManagerShop-create-form__inner">
                        <label class="shopManagerShop-create-form__label" for="detail">詳細文</label>
                        <textarea class="shopManagerShop-create-form__textarea" name="detail" id="detail">{{ old('detail') }}</textarea>
                    </div>
                    <div class="shopManagerShop-create-form__error">
                        @error('detail')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="shopManagerShop-create-form__group">
                    <div class="shopManagerShop-create-form__inner">
                        <label class="shopManagerShop-create-form__label">店舗写真</label>
                        <div class="shop-image__wrapper">
                            <div class="shop-image-preview" id="shopImagePreview"></div>
                            <label class="shopManagerShop-create-form__span--image" for="shop_img">画像を選択</label>
                            <input class="shopManagerShop-create-form__input" id="shop_img" type="file" name="shop_img" accept="image/*">
                        </div>
                    </div>
                    <div class="shopManagerShop-create-form__error">
                        @error('shop_img')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="shopManagerShop-create-form__btn">
                    <div class="shopManagerShop-create-form__btn-link">
                        <a class="shopManagerShop-create-form__btn-link--back" href="{{ route('shop-manager.shop.index') }}">&lt; 戻る</a>
                    </div>
                    <div class="shopManagerShop-create-form__btn-submit">
                        <input class="shopManagerShop-create-form__btn-submit--create" type="submit" value="店舗を作成する">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('shop_img').addEventListener('change', function(event){
            const file = event.target.files[0];
            const preview = document.getElementById('shopImagePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.style.backgroundImage = `url('${e.target.result}')`;
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.backgroundImage = '';
            }
        });
    </script>
@endsection

