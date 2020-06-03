<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <header class="l-header">
        <div class="p-header">
            <div class="p-header__logo"><a href="">WorkClock</a></div>
            <nav class="p-header__nav">
                <ul class="p-nav">
                    <li class="p-nav__item"><a href="">ログイン</a></li>
                    <li class="p-nav__item"><a href="">新規登録</a></li>
                    <li class="p-nav__item"><a href="">test</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="l-main">
        <div class="l-main-menu">
            <ul class="dropdwn" style="background: steelblue; height: 100%; color: white">
                <li style="border-bottom: 1px solid #eee;">組織
                    <ul class="dropdwn_menu" style="display: none ;color: white">
                        <li><a href="#">A1</a></li>
                        <li><a href="#">A2</a></li>
                    </ul>
                </li>
                <li>打刻
                    <ul class="dropdwn_menu">
                        <li><a href="#">A1</a></li>
                        <li><a href="#">A2</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="l-main-content">
            @yield('content')
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
