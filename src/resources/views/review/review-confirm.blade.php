@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/review/review-confirm.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="review-confirm__content">
        <div class="review-confirm__heading">
            <h2>投稿内容の確認</h2>
        </div>
        <div class="review-confirm__table-form">
            <form class="review-confirm-form" action="{{ route('reviews.store', ['reservation' => $reservation->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                <input type="hidden" name="shop_id" value="{{ $reservation->shop->id }}">
                <table class="review-confirm-table__inner">
                    <tr class="review-confirm-table__row">
                        <th class="review-confirm-table__heading">ユーザー名<span class="required">必須</span></th>
                        <td class="review-confirm-table__item">
                            @if($review['is_anonymous'])
                                匿名
                            @else
                                {{ $user->name }}
                            @endif
                            <input type="hidden" name="is_anonymous" value="{{ $review['is_anonymous'] }}">
                        </td>
                    </tr>
                    <tr class="review-confirm-table__row">
                        <th class="review-confirm-table__heading">店名</th>
                        <td class="review-confirm-table__item">{{ $reservation->shop->shopName }}</td>
                    </tr>
                    <tr class="review-confirm-table__row">
                        <th class="review-confirm-table__heading">来店日</th>
                        <td class="review-confirm-table__item">{{ \Carbon\Carbon::parse($reservation->date)->format('Y年m月d日') }}</td>
                    </tr>
                    <tr class="review-confirm-table__row">
                        <th class="review-confirm-table__heading">お店の評価<span class="required">必須</span></th>
                        <td class="review-confirm-table__item">
                            <div class="rating-confirm">
                                @for($i =1; $i <=5; $i++)
                                    @if($i <= old('evaluation', $review['evaluation']))
                                        ★
                                    @else
                                        ☆
                                    @endif
                                @endfor
                            </div>
                            <input type="hidden" name="evaluation" value="{{ $review['evaluation'] }}">
                        </td>
                    </tr>
                    <tr class="review-confirm-table__row">
                        <th class="review-confirm-table__heading review-confirm-table__heading--last">感想・コメント</th>
                        <td class="review-confirm-table__item review-confirm-table__item--last">
                            <textarea class="review-confirm-form__textarea" name="comment" id="comment" readonly>{{ $review['comment'] }}</textarea>
                        </td>
                    </tr>
                </table>
                <div class="review-confirm-form__btn">
                    <input class="review-confirm-form__btn--review" type="submit" value="レビューを投稿する">
                </div>
            </form>
        </div>
    </div>
@endsection
