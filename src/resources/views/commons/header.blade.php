<header class="header">
    <div class="header__inner">
        <div class="header__logo">
            <h1><a href="{{ route('shop.index') }}">MyBestRese</a></h1>
        </div>
        <div class="header-nav">
            <nav>
                <ul class="header-nav__items">
                    @if(Auth::check())
                        <li class="header-nav__item"><a class="header-nav__link" href="{{ route('shop.index') }}">ホーム</a></li>
                        @can('admin-higher')
                            <li class="header-nav__item"><a class="header-nav__link" href="{{ route('admin.shop-manager.index') }}">ダッシュボード</a></li>
                        @elsecan('shopManager-higher')
                            <li class="header-nav__item"><a class="header-nav__link" href="{{ route('shop-manager.shop.index') }}">ダッシュボード</a></li>
                        @elsecan('user-higher')
                            <li class="header-nav__item"><a class="header-nav__link" href="{{ route('mypage.show') }}">マイページ</a></li>
                            <li class="header-nav__item"><a class="header-nav__link" href="{{ route('payment.form') }}">決済</a></li>
                        @endcan
                        <li class="header-nav__item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <input class="header-nav__item--logout-btn" type="submit" value="ログアウト">
                            </form>
                        </li>
                    @else
                        <li class="header-nav__item"><a class="header-nav__link" href="{{ route('shop.index') }}">ホーム</a></li>
                        <li class="header-nav__item"><a class="header-nav__link" href="{{ route('register') }}">会員登録</a></li>
                        <li class="header-nav__item"><a class="header-nav__link" href="{{ route('login') }}">ログイン</a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</header>
