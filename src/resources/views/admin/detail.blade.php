@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/detail.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="shopManager-detail__container">
        <div class="shopManager-detail__btn">
            <a class="shopManager-detail__btn--Link-back" href="{{ route('admin.index') }}">&lt; 一覧に戻る</a>
        </div>
        <div class="shopManager-detail__header">
            <h2>基本情報</h2>
        </div>
        @if(session('success'))
            <div class="shopManager-detail__alert--success">
                {{ session('success') }}
            </div>
        @endif
        <div class="shopManager-detail__form">
            <form class="shopManager-edit-form" action="{{ route('admin.update', $shopManager->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="shopManagers-edit-table__wrapper">
                    <table class="shopManager-edit-table__content">
                        <tr class="shopManager-edit-table__row">
                            <th class="shopManager-edit-table__heading">名前</th>
                            <td class="shopManager-edit-table__item">
                                <input class="shopManager-edit__input" type="text" name="name" value="{{ old('name', $shopManager->name) }}">
                            </td>
                        </tr>
                        <tr class="shopManager-edit-table__row--error">
                            <th></th>
                            <td class="shopManager-edit-table__item--error">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </td>
                        </tr>
                        <tr class="shopManager-edit-table__row">
                            <th class="shopManager-edit-table__heading">メールアドレス</th>
                            <td class="shopManager-edit-table__item">
                                <input class="shopManager-edit__input" type="email" name="email" value="{{ old('email', $shopManager->email) }}">
                            </td>
                        </tr>
                        <tr class="shopManager-edit-table__row--error">
                            <th></th>
                            <td class="shopManager-edit-table__item--error">
                                @error('email')
                                {{ $message }}
                                @enderror
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="shopManager-edit-form__btn">
                    <input type="submit" class="shopManager-edit-form__btn--submit" value="保存">
                </div>
            </form>
        </div>
    </div>
    <div class="shopManager-shopList__container">
        <div class="shopManager-shopList__header">
            <h2>店舗一覧</h2>
        </div>
        <div class="shopManager-shopList-table">
        </div>
    </div>
@endsection