@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
@endsection

@section('content')
    <div class="admin-index__heading">
        <h2>店舗代表者一覧</h2>
    </div>
    <div class="shopManager-search">
        <form method="GET" action="{{ route('admin.shop-manager.index') }}" class="shopManager-search-form">
            @csrf
            <div class="shopManager-search-form__inner">
                <div class="shopManager-search-form__item-input">
                    <input class="search-form__item-input-keyword" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="キーワードを入力">
                </div>
                <div class="shopManager-search-form_btns">
                    <div class="shopManager-search-form_btn">
                        <a class="shopManager-search-form_btn--reset" href="{{ route('admin.shop-manager.index') }}"><i class="fa-solid fa-rotate-right"></i> リセット</a>
                    </div>
                    <div class="shopManager-search-form_btn">
                        <button class="shopManager-search-form_btn--search" type="submoit"><i class="fa-solid fa-magnifying-glass"></i> 検索</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="admin-index__shopManager-create-btn">
        <a class="shopManager-create-btn__link" href="{{ route('admin.shop-manager.create') }}"><i class="fa-solid fa-plus"></i> 新規作成</a>
    </div>
    <div class="shopManagers-list__content">
        @if($shopManagers->isEmpty())
            <p>該当するデータが見つかりませんでした。</p>
        @else
            <div class="shopManagers-table__wrapper">
                <table class="shopManagers-table">
                    <tr class="shopManagers-table__row">
                        <th class="shopManagers-table__heading">名前</th>
                        <th class="shopManagers-table__heading">メールアドレス</th>
                        <th class="shopManagers-table__heading"></th>
                    </tr>
                    @foreach($shopManagers as $shopManager)
                        <tr class="shopManagers-table__row">
                            <td class="shopManagers-table__item">{{ $shopManager->name }}</td>
                            <td class="shopManagers-table__item">{{ $shopManager->email }}</td>
                            <td class="shopManagers-table__item">
                                <button class="shopManagers-table__btn">
                                    <a class="shopManagers-table__btn--detail" href="{{ route('admin.shop-manager.show', $shopManager->id)}}"><i class="fa-solid fa-pen-to-square"></i> 詳細</a>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    </div>
    <div class="shopManagers__paginate">
        {{ $shopManagers->links() }}
    </div>
@endsection
