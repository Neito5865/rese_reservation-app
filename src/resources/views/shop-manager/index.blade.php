@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/shop-manager/index.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="shopManager-index__heading">
        <h2>店舗一覧</h2>
    </div>
    <div class="shopManager-index__shop-create-btn">
        <a class="shopManagerShop-create-btn__link" href="{{ route('shopManager.create') }}"><i class="fa-solid fa-plus"></i> 新規作成</a>
    </div>
    <div class="shopManagerShops-list__content">
        @if($shopManagerShops->isEmpty())
            <p>該当するデータが見つかりませんでした。</p>
        @else
            <div class="shopManagerShops-table__wrapper">
                <table class="shopManagerShops-table">
                    <tr class="shopManagerShops-table__row">
                        <th class="shopManagerShops-table__heading">写真</th>
                        <th class="shopManagerShops-table__heading">店名</th>
                        <th class="shopManagerShops-table__heading">お気に入り</th>
                        <th class="shopManagerShops-table__heading"></th>
                    </tr>
                    @foreach($shopManagerShops as $shop)
                        <tr class="shopManagerShops-table__row">
                            <td class="shopManagerShops-table__item"><img src="{{ asset('storage/' . $shop->shopImg) }}" alt="{{ $shop->shopName }}"></td>
                            <td class="shopManagerShops-table__item">{{ $shop->shopName }}</td>
                            @php
                                $countFavoriteUsers = $shop->favoriteUsers()->count();
                            @endphp
                            <td class="shopManagerShops-table__item"><i class="fa-solid fa-heart"></i> {{ $countFavoriteUsers }}</td>
                            <td class="shopManagerShops-table__item">
                                <button class="shopManagerShops-table__btn">
                                    <a class="shopManagerShops-table__btn--detail" href="{{ route('shopManager.detail', $shop->id) }}"><i class="fa-solid fa-pen-to-square"></i> 編集</a>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    </div>
    <div class="shopManagerShop__paginate">
        {{ $shopManagerShops->links() }}
    </div>
@endsection