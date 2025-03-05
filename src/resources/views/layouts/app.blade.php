<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    @include('commons.header')
    @yield('content')
    @include('commons.footer')
    @yield('script')
    <script src="https://kit.fontawesome.com/bbc02bbca9.js" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hamburger = document.querySelector(".hamburger");
            const nav = document.querySelector(".header-nav__items");

            hamburger.addEventListener("click", function() {
                nav.classList.toggle("active");
                hamburger.classList.toggle("active");
            });

            document.addEventListener("click", function(event) {
                if (!nav.contains(event.target) && !hamburger.contains(event.target)) {
                    nav.classList.remove("active");
                    hamburger.classList.remove("active");
                }
            });
        });
    </script>
</body>
</html>
