@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/shop-manager/detail.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="shopManagerShop-detail__container">
        <div class="shopManagerShop-detail__btn">
            <a class="shopManagerShop-detail__btn--Link-back" href="{{ route('shopManager.index') }}">&lt; 一覧に戻る</a>
        </div>
        <div class="shopManagerShop-detail__header">
            <h2>店舗情報</h2>
        </div>
        @if(session('success'))
            <div class="shopManagerShop-detail__alert--success">
                {{ session('success') }}
            </div>
        @endif
        <div class="shopManagerShop-detail__form">
            <form class="shopManagerShop-edit-form" action="{{ route('shopManager.update', $shopManagerShop->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="shopManagersShop-edit-table__wrapper">
                    <table class="shopManagerShop-edit-table__content">
                        <tr class="shopManagerShop-edit-table__row">
                            <th class="shopManagerShop-edit-table__heading">店名</th>
                            <td class="shopManagerShop-edit-table__item">
                                <input class="shopManagerShop-edit__input" type="text" name="shopName" value="{{ old('shopName', $shopManagerShop->shopName) }}">
                            </td>
                        </tr>
                        <tr class="shopManagerShop-edit-table__row--error">
                            <th></th>
                            <td class="shopManagerShop-edit-table__item--error">
                                @error('shopName')
                                {{ $message }}
                                @enderror
                            </td>
                        </tr>
                        <tr class="shopManagerShop-edit-table__row">
                            <th class="shopManagerShop-edit-table__heading">エリア</th>
                            <td class="shopManagerShop-edit-table__item">
                                <div class="shopManagerShop-create-form__select">
                                    <select name="area_id" id="area" class="shopManagerShop-create-form__select--area">
                                        <option value="">選択してください</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}" {{ old('area_id', $shopManagerShop->area_id) == $area->id ? 'selected' : '' }}>{{ $area->area }}</option>
                                        @endforeach
                                    </select>
                                    <i class="fa-solid fa-sort-down custom-arrow-area"></i>
                                </div>
                            </td>
                        </tr>
                        <tr class="shopManagerShop-edit-table__row--error">
                            <th></th>
                            <td class="shopManagerShop-edit-table__item--error">
                                @error('area_id')
                                {{ $message }}
                                @enderror
                            </td>
                        </tr>
                        <tr class="shopManagerShop-edit-table__row">
                            <th class="shopManagerShop-edit-table__heading">ジャンル</th>
                            <td class="shopManagerShop-edit-table__item">
                                <div class="shopManagerShop-create-form__select">
                                    <select name="genre_id" id="genre" class="shopManagerShop-create-form__select--genre">
                                        <option value="">選択してください</option>
                                        @foreach($genres as $genre)
                                            <option value="{{ $genre->id }}" {{ old('genre_id', $shopManagerShop->genre_id) == $genre->id ? 'selected' : '' }}>{{ $genre->genre }}</option>
                                        @endforeach
                                    </select>
                                    <i class="fa-solid fa-sort-down custom-arrow-genre"></i>
                                </div>
                            </td>
                        </tr>
                        <tr class="shopManagerShop-edit-table__row--error">
                            <th></th>
                            <td class="shopManagerShop-edit-table__item--error">
                                @error('genre_id')
                                {{ $message }}
                                @enderror
                            </td>
                        </tr>
                        <tr class="shopManagerShop-edit-table__row">
                            <th class="shopManagerShop-edit-table__heading">詳細文</th>
                            <td class="shopManagerShop-edit-table__item">
                                <textarea class="shopManagerShop-create-form__textarea" name="detail" id="detail">{{ old('detail', $shopManagerShop->detail) }}</textarea>
                            </td>
                        </tr>
                        <tr class="shopManagerShop-edit-table__row--error">
                            <th></th>
                            <td class="shopManagerShop-edit-table__item--error">
                                @error('detail')
                                {{ $message }}
                                @enderror
                            </td>
                        </tr>
                        <tr class="shopManagerShop-edit-table__row">
                            <th class="shopManagerShop-edit-table__heading">店舗写真</th>
                            <td class="shopManagerShop-edit-table__item">
                                @if($shopManagerShop->shopImg)
                                    <div id="current-image-wrapper">
                                        <img id="current-image" src="{{ asset('storage/' . $shopManagerShop->shopImg) }}" alt="店舗写真" style="max-width: 200px; max-height: 150px;">
                                        <button type="button" id="delete-image-btn"><i class="fa-solid fa-trash-can"></i></button>
                                    </div>
                                @endif
                                <input class="shopManagerShop-edit-form__input" id="shopImg" type="file" name="shopImg" value="">
                                <img id="uploaded-image-preview" style="display: none; max-width: 200px; max-height: 150px;">
                            </td>
                        </tr>
                        <tr class="shopManagerShop-edit-table__row--error">
                            <th></th>
                            <td class="shopManagerShop-edit-table__item--error">
                                @error('shopImg')
                                {{ $message }}
                                @enderror
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="shopManagerShop-edit-form__btn">
                    <input type="submit" class="shopManagerShop-edit-form__btn--submit" value="保存">
                </div>
            </form>
        </div>
    </div>
    <div class="shopManagerShop-reservationList__container">
        <div class="shopManagerShop-reservationList__header">
            <h2>予約一覧</h2>
        </div>
        <div class="shopManagerShop-reservationList-table">
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 画像削除ボタンの処理
            const deleteImageBtn = document.getElementById('delete-image-btn');
            const currentImageWrapper = document.getElementById('current-image-wrapper');
            const shopImgInput = document.getElementById('shopImg');
            const uploadedImagePreview = document.getElementById('uploaded-image-preview');

            if (deleteImageBtn) {
                deleteImageBtn.addEventListener('click', function () {
                    // 画像を削除したい場合、既存の画像を非表示に
                    currentImageWrapper.style.display = 'none';
                    // 画像フィールドのリセット
                    shopImgInput.value = '';
                    uploadedImagePreview.style.deiplay = 'none';
                });
            }

            // 新しい画像のプレビュー表示
            shopImgInput.addEventListener('change', function (event) {
                const file = event.target.files[0];

                if (file) {
                    // 新しい画像が選択されたら、既存の画像を非表示にする
                    if (currentImageWrapper){
                        currentImageWrapper.style.display = 'none';
                    }

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
