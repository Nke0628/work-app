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
            <ul class="l-drop-down-menu">
                <li class="l-drop-down-menu__item"><i class="far fa-building"></i>組織
                    <ul class="l-drop-down-menu-sub">
                        <li class="l-drop-down-menu-sub__item"><a href="#">組織一覧</a></li>
                        <li class="l-drop-down-menu-sub__item"><a href="#">組織登録</a></li>
                    </ul>
                </li>
                <li class="l-drop-down-menu__item"><i class="far fa-clock"></i>打刻
                    <ul class="l-drop-down-menu-sub">
                        <li class="l-drop-down-menu-sub__item"><a href="#">打刻画面</a></li>
                        <li class="l-drop-down-menu-sub__item"><a href="#">打刻一覧</a></li>
                    </ul>
                </li>
                <li class="l-drop-down-menu__item"><i class="far fa-user"></i>スタッフ
                    <ul class="l-drop-down-menu-sub">
                        <li class="l-drop-down-menu-sub__item"><a href="#">スタッフ一覧</a></li>
                        <li class="l-drop-down-menu-sub__item"><a href="#">スタッフ登録</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="l-main-content">
            @yield('content')
        </div>
    </main>
    <footer style="height: 200px">
    </footer>
</body>
</html>
