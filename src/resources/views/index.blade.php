@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="header-search__flex">
        @include('commons.header')
        <div class="search">
            <form method="GET" action="{{ route('shops.search') }}" class="search-form">
                @csrf
                <div class="search-form__inner">
                    <div class="search-form__item-select">
                        <select name="area_id" id="area" class="search-form__item-select-area">
                            <option value="">All area</option>
                            @foreach($areas as $area)
                                <option value="{{ $area['id'] }}">{{ $area['area'] }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-sort-down custom-arrow"></i>
                    </div>
                    <div class="search-form__item-select">
                        <select name="genre_id" id="genre" class="search-form__item-select-genre">
                            <option value="">All genre</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre['id'] }}">{{ $genre['genre'] }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-sort-down custom-arrow"></i>
                    </div>
                    <div class="search-form__item-input">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input class="search-form__item-input-keyword" type="text" name="keyword" value="{{ old('keyword') }}" id="keyword" placeholder="Search ...">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="shopAll__content" id="shop-list">
        <div class="shop-card__flex">
            @foreach($shops as $shop)
                <div class="shop-card">
                    <div class="shop-card__img">
                        <img src="{{ asset('storage/' . $shop['shopImg']) }}" alt="{{ $shop['shopName'] }}">
                    </div>
                    <div class="shop-card__content">
                        <h3 class="shop-card__heading">{{ $shop['shopName'] }}</h3>
                        <div class="shop-card__tag">
                            <span class="shop-card__tag--area">#{{ $shop['area']['area'] }}</span>
                            <span class="shop-card__tag--genre">#{{ $shop['genre']['genre'] }}</span>
                        </div>
                        <div class="shop-card__content--flex">
                            <div class="shop-card__link">
                                <a href="{{ route('shop.show', ['id' => $shop['id']]) }}" class="shop-card__link-detail">詳しくみる</a>
                            </div>
                            <form class="shop-card__form">
                                @csrf
                                <button class="shop-card__btn--favorite" type="submit"><i class="fa-solid fa-heart"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('script')
    <script>
        // フォームの入力を監視
        document.querySelectorAll('#area, #genre, #keyword').forEach(input => {
            input.addEventListener('input', function(){
                let area_id = document.querySelector('#area').value;
                let genre_id = document.querySelector('#genre').value;
                let keyword = document.querySelector('#keyword').value;

                // クエリパラメータを作成
                let queryParams = new URLSearchParams({
                    area_id: area_id,
                    genre_id: genre_id,
                    keyword: keyword
                });

                // Ajaxで検索を実行
                fetch(`{{ route('shops.search') }}?${queryParams.toString()}`,{
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest', // Ajaxリクエストであることを指定
                    },
                })
                .then(response => response.json())
                .then(data => {
                    // 結果をHTMLに挿入
                    const shopList = document.querySelector('#shop-list .shop-card__flex');
                    shopList.innerHTML = ''; // 一度リストをクリア
                    data.shops.forEach(shop => {
                        shopList.innerHTML += `
                            <div class="shop-card">
                                <div class="shop-card__img">
                                    <img src="/storage/${shop.shopImg}" alt="${shop.shopName}">
                                </div>
                                <div class="shop-card__content">
                                    <h3 class="shop-card__heading">${shop.shopName}</h3>
                                    <div class="shop-card__tag">
                                        <span class="shop-card__tag--area">#${shop.area.area}</span>
                                        <span class="shop-card__tag--genre">#${shop.genre.genre}</span>
                                    </div>
                                    <div class="shop-card__content--flex">
                                        <div class="shop-card__link">
                                            <a href="{{ route('shop.show', ['id' => $shop['id']]) }}" class="shop-card__link-detail">詳しくみる</a>
                                        </div>
                                        <form class="shop-card__form">
                                            @csrf
                                            <button class="shop-card__btn--favorite" type="submit"><i class="fa-solid fa-heart"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endsection
