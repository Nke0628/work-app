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
            <div class="p-header__logo"><a href="">TITLE</a></div>
            <nav class="p-header__nav">
                <ul class="p-nav">
                    <li class="p-nav__item"><a href="">test</a></li>
                    <li class="p-nav__item"><a href="">test</a></li>
                    <li class="p-nav__item"><a href="">test</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="l-main">
        <div class="l-main-menu"></div>
        <div class="l-main-content">
            @yield('content')
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
