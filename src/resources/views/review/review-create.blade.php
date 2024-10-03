@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/review/review-create.css') }}">
@endsection

@section('content')
    @include('commons.header')
    <div class="review__content">
        <div class="review__heading">
            <h2>レビューを投稿する</h2>
        </div>
        <div class="review__table-form">
            <form class="review-form" action="{{ route('reviews.confirm') }}" method="POST">
                @csrf
                <table class="review-table__inner">
                    <tr class="review-table__row">
                        <th class="review-table__heading">{{ optional($reservation->shop)->shopName }}</th>
                        <td class="review-table__item"></td>
                    </tr>
                    <tr class="review-table__row">
                        <th class="review-table__heading">来店日</th>
                        <td class="review-table__item">{{ $reservation->date }}</td>
                    </tr>
                    <tr class="review-table__row">
                        <th class="review-table__heading">お店の評価</th>
                        <td class="review-table__item">
                            <div class="rating">
                                <input class="review-form__input--rate" type="radio" id="star5" name="evalution" value="5">
                                <label class="review-form__label--rate" for="star5" title="5 stars">★</label>
                                <input class="review-form__input--rate" type="radio" id="star4" name="evalution" value="4">
                                <label class="review-form__label--rate" for="star4" title="4 stars">★</label>
                                <input class="review-form__input--rate" type="radio" id="star3" name="evalution" value="3">
                                <label class="review-form__label--rate" for="star3" title="3 stars">★</label>
                                <input class="review-form__input--rate" type="radio" id="star2" name="evalution" value="2">
                                <label class="review-form__label--rate" for="star2" title="2 stars">★</label>
                                <input class="review-form__input--rate" type="radio" id="star1" name="evalution" value="1">
                                <label class="review-form__label--rate" for="star1" title="1 star">★</label>
                            </div>
                        </td>
                    </tr>
                    <tr class="review-table__row">
                        <th class="review-table__heading review-table__heading--last">感想・コメント</th>
                        <td class="review-table__item review-table__item--last">
                            <textarea class="review-form__textarea" name="comment" id="comment"></textarea>
                        </td>
                    </tr>
                </table>
                <div class="review-form__btn">
                    <input class="review-form__btn--confirm" type="submit" value="投稿内容を確認する">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.rating input').click(function(){
                let ratingValue = $(this).val();
                console.log("Selected Rating: " + ratingValue);
            });
        });
    </script>
@endsection
