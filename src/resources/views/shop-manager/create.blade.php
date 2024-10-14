@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/shop-manager/create.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="shopManagerShop-create__content">
        @if(session('success'))
            <div class="shopManagerShop-create__alert--success">
                {{ session('success') }}
            </div>
        @endif
        <div class="shopManagerShop-create__heading">
            <h2>新規店舗作成</h2>
        </div>
        <div class="shopManagerShop-create__form">
            <form method="POST" action="{{ route('shopManager.store') }}" class="shopManagerShop-create-form" enctype="multipart/form-data">
                @csrf
                <div class="shopManagerShop-create-form__group">
                    <div class="shopManagerShop-create-form__inner">
                        <label class="shopManagerShop-create-form__label" for="shopName">店名</label>
                        <input class="shopManagerShop-create-form__input" id="shopName" type="text" name="shopName" value="{{ old('shopName') }}">
                    </div>
                    <div class="shopManagerShop-create-form__error">
                        @error('shopName')
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
                                    <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->area }}</option>
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
                                    <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>{{ $genre->genre }}</option>
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
                        <label class="shopManagerShop-create-form__label" for="shopImg">店舗写真</label>
                        <input class="shopManagerShop-create-form__input" id="shopImg" type="file" name="shopImg">
                    </div>
                    <div class="shopImg-preview">
                        <img id="uploaded-image-preview" style="display: none; max-width: 200px; max-height: 150px;">
                    </div>
                    <div class="shopManagerShop-create-form__error">
                        @error('shopImg')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="shopManagerShop-create-form__btn">
                    <div class="shopManagerShop-create-form__btn-link">
                        <a class="shopManagerShop-create-form__btn-link--back" href="{{ route('shopManager.index') }}">&lt; 戻る</a>
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
        document.addEventListener('DOMContentLoaded', function () {
            // 要素の取得
            const shopImgInput = document.getElementById('shopImg');
            const uploadedImagePreview = document.getElementById('uploaded-image-preview');

            // 新しい画像のプレビュー表示
            shopImgInput.addEventListener('change', function (event) {
                const file = event.target.files[0];

                if (file) {
                    // 新しい画像のプレビュー表示
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        uploadedImagePreview.src = e.target.result;
                        uploadedImagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    uploadedImagePreview.style.display = 'none';
                }
            });
        });
    </script>
@endsection

