
<div class="shop-card__flex">
    @if($shops->isEmpty())
        <p>該当する店舗が見つかりませんでした。</p>
    @else
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
                            <a href="{{ route('shop.detail', ['shop_id' => $shop['id']]) }}" class="shop-card__link-detail">詳しくみる</a>
                        </div>
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
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
