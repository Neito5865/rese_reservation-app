@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="search">
        <div class="search__header">
            <h2>マイベストなお店を探す</h2>
        </div>
        <form method="GET" action="{{ route('shop.index') }}" class="search-form" id="search-form">
            @csrf
            <div class="search-form__inner">
                <div class="search-form__item-select">
                    <select name="area_id" id="area" class="search-form__item-select-area">
                        <option value="">エリア</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->prefecture }}</option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-sort-down custom-arrow"></i>
                </div>
                <div class="search-form__item-select">
                    <select name="genre_id" id="genre" class="search-form__item-select-genre">
                        <option value="">ジャンル</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>{{ $genre->content }}</option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-sort-down custom-arrow"></i>
                </div>
                <div class="search-form__item-input">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input class="search-form__item-input-keyword" type="text" name="keyword" value="{{ request('keyword') }}" id="keyword" placeholder="キーワードを入力">
                </div>
            </div>
        </form>
    </div>
    <div class="shop-list__content" id="shop-list">
        <div class="shop-card__flex">
            @if($shops->isEmpty())
                <p>該当する店舗が見つかりませんでした。</p>
            @else
                @foreach($shops as $shop)
                    <div class="shop-card">
                        <div class="shop-card__img">
                            <img src="{{ asset('storage/' . $shop->shop_img) }}" alt="{{ $shop->shop_name }}">
                        </div>
                        <div class="shop-card__content">
                            <h3 class="shop-card__heading">{{ $shop->shop_name }}</h3>
                            <div class="shop-card__tag">
                                <span class="shop-card__tag--area">#{{ $shop->area->prefecture }}</span>
                                <span class="shop-card__tag--genre">#{{ $shop->genre->content }}</span>
                            </div>
                            <div class="shop-card__content--flex">
                                <div class="shop-card__link">
                                    <a href="{{ route('shop.show', $shop->id) }}" class="shop-card__link-detail">詳しくみる</a>
                                </div>
                                @can('user-higher')
                                    @if(Auth::check())
                                        @if(Auth::user()->isFavorite($shop->id))
                                            <form class="shop-card__form" method="POST" action="{{ route('unfavorite', $shop->id) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button class="shop-card__btn--favorite favorited" type="submit"><i class="fa-solid fa-heart"></i></button>
                                            </form>
                                        @else
                                            <form class="shop-card__form" method="POST" action="{{ route('favorite', $shop->id) }}">
                                                @csrf
                                                <button class="shop-card__btn--favorite" type="submit"><i class="fa-solid fa-heart"></i></button>
                                            </form>
                                        @endif
                                    @endif
                                @endcan
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const form = document.getElementById('search-form');
            const areaSelect = document.getElementById('area');
            const genreSelect = document.getElementById('genre');
            const keywordInput = document.getElementById('keyword');

            areaSelect.addEventListener('change', function(){
                form.submit();
            });

            genreSelect.addEventListener('change', function(){
                form.submit();
            });

            keywordInput.addEventListener('input', function(){
                clearTimeout(this.delay);
                this.delay = setTimeout(function(){
                    form.submit();
                }.bind(this), 500); // 0.5秒後に送信
            });
        });
    </script>
@endsection
