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
                    <li class="header-nav__item"><a class="header-nav__link" href="/">Home</a></li>
                    <li class="header-nav__item">
                        <form method="POST" action="/logout">
                            @csrf
                            <input class="header-nav__item--logout-btn" type="submit" value="Logout">
                        </form>
                    </li>
                    <li class="header-nav__item"><a class="header-nav__link" href="/mypage">Mypage</a></li>
                @else
                    <li class="header-nav__item"><a class="header-nav__link" href="/">Home</a></li>
                    <li class="header-nav__item"><a class="header-nav__link" href="/register">Registration</a></li>
                    <li class="header-nav__item"><a class="header-nav__link" href="/login">Login</a></li>
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
