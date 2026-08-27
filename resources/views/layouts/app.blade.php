<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'COACHTECH')</title>

    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a href="/">
                <img class="header__logo" src="{{ asset('images/logo.png') }}" alt="COACHTECH">
            </a>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">ログアウト</button>
                </form>
            @endauth
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>