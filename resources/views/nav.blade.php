<nav class='navbar navbar-expand navbar-dark cyan darken-3'>

    <a class="navbar-brand" href="/">mensetsu</a>

    <ul class="navbar-nav ml-auto">

        @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">ユーザー登録</a>
        </li>
        @endguest

        @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">ログイン</a>
        </li>
        @endguest

        @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('articles.create') }}"><i class="fas fa-pen mr-1"></i>投稿する</a>
            </li>
        @endauth

        @auth
        <li class="nav-item dropdown">
            <a href="" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                <button class="dropdown-item text-center" type="button" onclick="location.href=''">
                    マイページ
                </button>
                <div class="dropdown-divider"></div>
                <button form="logout-button" class="dropdown-item text-center" type="submit">
                    ログアウト
                </button>
            </div>
        </li>
        <form id="logout-button" method="post" action="{{ route('logout') }}">
            @csrf
        </form>
        @endauth
    </ul>
</nav>
