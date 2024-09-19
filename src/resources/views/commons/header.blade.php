<header class="header">
    <div class="header__inner">
        <div class="hamburger-button" onclick="toggleMenu(this)">
            <div class="hamburger-line"></div>
            <div class="hamburger-line"></div>
            <div class="hamburger-line"></div>
        </div>

        <ul class="header-nav">
            <div class="header-nav__items">
                @if(Auth::check())
                    <li class="header-nav__item"><a class="header-nav__link" href="{{ route('shops') }}">Home</a></li>
                    <li class="header-nav__item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <input class="header-nav__item--logout-btn" type="submit" value="Logout">
                        </form>
                    </li>
                    <li class="header-nav__item"><a class="header-nav__link" href="{{ route('mypage.show') }}">Mypage</a></li>
                @else
                    <li class="header-nav__item"><a class="header-nav__link" href="{{ route('shops') }}">Home</a></li>
                    <li class="header-nav__item"><a class="header-nav__link" href="{{ route('register') }}">Registration</a></li>
                    <li class="header-nav__item"><a class="header-nav__link" href="{{ route('login') }}">Login</a></li>
                @endif
            </div>
        </ul>

        <script>
            function toggleMenu(element){
                element.classList.toggle("active");
            }
        </script>

        <div class="header__logo">
            <a href="/">Rese</a>
        </div>
    </div>
</header>
