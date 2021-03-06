<nav class='navbar navbar-expand navbar-dark cyan darken-3'>

    <a class="navbar-brand" href="/">mensetsu</a>

    <ul class="navbar-nav ml-auto mr-3">

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
            <li class="nav-item mr-2 my-auto">
                <a class="nav-link bg-white text-default rounded-pill px-3" href="{{ route('articles.create') }}"><i class="fas fa-pen mr-1"></i>投稿する</a>
            </li>
        @endauth

        @auth
        <li class="nav-item dropdown">
            <a href="" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ $user->image }}" alt="Contact Person" class="img-fuild rounded-circle" width="30" height="30">
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                <button class="dropdown-item text-center" type="button" onclick="location.href='{{ route("users.show", ["name" => Auth::user()->name]) }}'">
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
