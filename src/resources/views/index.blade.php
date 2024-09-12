@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="header-search__flex">
        @include('commons.header')
        <div class="search">
            <form method="GET" action="" class="search-form">
                @csrf
                <div class="search-form__inner">
                    <div class="search-form__item-select">
                        <select name="area" id="" class="search-form__item-select-area">
                            <option value="">All area</option>
                            <option value="">サンプル</option>
                            <option value="">サンプル</option>
                        </select>
                    </div>
                    <div class="search-form__item-select">
                        <select name="genre" id="" class="search-form__item-select-genre">
                            <option value="">All genre</option>
                            <option value="">サンプル</option>
                            <option value="">サンプル</option>
                        </select>
                    </div>
                    <div class="search-form__item-input">
                        <input class="search-form__item-input-keyword" type="text" name="keyword" value="{{ old('keyword') }}" placeholder="Search ...">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="shopAll__content">
        <div class="shop-card__flex">
            <div class="shop-card">
                <div class="shop-card__img">
                    <img src="https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg" alt="仙人">
                </div>
                <div class="shop-card__content">
                    <h3 class="shop-card__heading">仙人</h3>
                    <div class="shop-card__tag">
                        <span class="shop-card__tag--area">#東京都</span>
                        <span class="shop-card__tag--genre">#寿司</span>
                    </div>
                    <div class="shop-card__content--flex">
                        <div class="shop-card__link">
                            <a href="" class="shop-card__link-detail">詳しくみる</a>
                        </div>
                        <form class="shop-card__form">
                            @csrf
                            <button class="shop-card__btn--favorite" type="submit"><i class="fa-solid fa-heart"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="shop-card">
                <div class="shop-card__img">
                    <img src="https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg" alt="仙人">
                </div>
                <div class="shop-card__content">
                    <h3 class="shop-card__heading">仙人</h3>
                    <div class="shop-card__tag">
                        <span class="shop-card__tag--area">#東京都</span>
                        <span class="shop-card__tag--genre">#寿司</span>
                    </div>
                    <div class="shop-card__content--flex">
                        <div class="shop-card__link">
                            <a href="" class="shop-card__link-detail">詳しくみる</a>
                        </div>
                        <form class="shop-card__form">
                            @csrf
                            <button class="shop-card__btn--favorite" type="submit"><i class="fa-solid fa-heart"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="shop-card">
                <div class="shop-card__img">
                    <img src="https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg" alt="仙人">
                </div>
                <div class="shop-card__content">
                    <h3 class="shop-card__heading">仙人</h3>
                    <div class="shop-card__tag">
                        <span class="shop-card__tag--area">#東京都</span>
                        <span class="shop-card__tag--genre">#寿司</span>
                    </div>
                    <div class="shop-card__content--flex">
                        <div class="shop-card__link">
                            <a href="" class="shop-card__link-detail">詳しくみる</a>
                        </div>
                        <form class="shop-card__form">
                            @csrf
                            <button class="shop-card__btn--favorite" type="submit"><i class="fa-solid fa-heart"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="shop-card">
                <div class="shop-card__img">
                    <img src="https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg" alt="仙人">
                </div>
                <div class="shop-card__content">
                    <h3 class="shop-card__heading">仙人</h3>
                    <div class="shop-card__tag">
                        <span class="shop-card__tag--area">#東京都</span>
                        <span class="shop-card__tag--genre">#寿司</span>
                    </div>
                    <div class="shop-card__content--flex">
                        <div class="shop-card__link">
                            <a href="" class="shop-card__link-detail">詳しくみる</a>
                        </div>
                        <form class="shop-card__form">
                            @csrf
                            <button class="shop-card__btn--favorite" type="submit"><i class="fa-solid fa-heart"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="shop-card">
                <div class="shop-card__img">
                    <img src="https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg" alt="仙人">
                </div>
                <div class="shop-card__content">
                    <h3 class="shop-card__heading">仙人</h3>
                    <div class="shop-card__tag">
                        <span class="shop-card__tag--area">#東京都</span>
                        <span class="shop-card__tag--genre">#寿司</span>
                    </div>
                    <div class="shop-card__content--flex">
                        <div class="shop-card__link">
                            <a href="" class="shop-card__link-detail">詳しくみる</a>
                        </div>
                        <form class="shop-card__form">
                            @csrf
                            <button class="shop-card__btn--favorite" type="submit"><i class="fa-solid fa-heart"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
