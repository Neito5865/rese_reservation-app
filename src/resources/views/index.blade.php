@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="header-search__flex">
        @include('commons.header')
        <div class="search">
            <form method="GET" action="{{ route('shops.search') }}" class="search-form" id="search-form">
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
        @include('partials.shop-list', ['shops' => $shops])
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
        // 検索フォームのエリア、ジャンル、キーワードの変更を検知してAjaxで検索
        $('#area, #genre, #keyword').on('change keyup', function(){
            clearTimeout(timer);
            timer = setTimeout(function(){
                var area = $('#area').val();
                var genre = $('#genre').val();
                var keyword = $('#keyword').val();

                $.ajax({
                    url: "{{ route('shops.search') }}",
                    type: 'GET',
                    data: {
                        area_id: area,
                        genre_id: genre,
                        keyword: keyword
                    },
                    success: function(data){
                        $('#shop-list').html(data);
                    },
                    error: function(){
                        alert('検索に失敗しました。');
                    }
                });
            }, 500);
        });

        // お気に入りボタンのAjax処理
        $(document).on('submit', '.favorite-form', function(e) {
            e.preventDefault(); // フォームのデフォルト送信を無効化

            var form = $(this);
            var formData = form.serialize(); // フォームデータを取得

            $.ajax({
                url: form.attr('action'),  // フォームのアクションURLを取得
                type: form.attr('method'), // フォームのメソッドを取得（POST or DELETE）
                data: formData,            // フォームデータを送信
                success: function(response) {
                    // 成功時にボタンの見た目を切り替え（例: クラスの追加/削除）
                    if (response.status === 'favorited') {
                        form.find('button').addClass('favorited');
                    } else if (response.status === 'unfavorited') {
                        form.find('button').removeClass('favorited');
                    }
                },
                error: function() {
                    alert('お気に入り処理に失敗しました。');
                }
            });
        });
    });
</script>
@endsection
