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

            {{-- ロゴ --}}
            <a class="header__logo-link" href="{{ route('items.index') }}">
                <img class="header__logo" src="{{ asset('images/logo.png') }}" alt="COACHTECH">
            </a>

            {{-- 商品検索 --}}
            <form class="header__search" action="{{ route('items.index') }}" method="GET">
                @if (request('page') === 'mylist')
                    <input type="hidden" name="page" value="mylist">
                @endif

                <input class="header__search-input" type="text" name="keyword" value="{{ request('keyword') }}"
                    placeholder="なにをお探しですか？">
            </form>

            {{-- ナビゲーション --}}
            <nav class="header__nav">
                @auth
                    <form class="header__logout-form" method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button class="header__logout-button" type="submit">
                            ログアウト
                        </button>
                    </form>

                    <a class="header__nav-link" href="{{ route('profile.index') }}">
                        マイページ
                    </a>

                    <a class="header__sell-button" href="{{ route('sell.create') }}">
                        出品
                    </a>
                @else
                    <a class="header__nav-link" href="{{ route('login') }}">
                        ログイン
                    </a>
                @endauth
            </nav>

        </div>
    </header>

    <main>
        @yield('content')
    </main>

    @yield('script')
</body>

</html>