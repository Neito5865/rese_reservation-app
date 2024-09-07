<header class="header">
    <div class="header__inner">
        <div class="hamburger-button" onclick="toggleMenu(this)">
            <div class="hamburger-line"></div>
            <div class="hamburger-line"></div>
            <div class="hamburger-line"></div>
        </div>

        <ul class="header-nav">
            <div class="header-nav__items">
                <li class="header-nav__item"><a class="header-nav__link" href="">Home</a></li>
                <li class="header-nav__item"><a class="header-nav__link" href="">Registration</a></li>
                <li class="header-nav__item"><a class="header-nav__link" href="">Login</a></li>
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
