@extends('app')

@section('title', 'ログイン')

@section('content')

    @include('nav')

    <div class="row">
        <div class="mx-auto col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6">
            <div class="card mt-5">
                <div class="card-body text-center mt-5">
                    <h2 class='h4 card-title text-center mt-5 mb-1'><span class="bg cyan darken-3 text-white py-3 px-4 rounded-pill">ログイン</span></h2>
                    <p class="mt-4">Login</p>

                    <a href="{{ route('login.{provider}', ['provider' => 'google']) }}" class="btn btn-block btn-danger my-3">
                        <i class="fab fa-google mr-1"></i>Googleでログイン
                    </a>

                    @include('error_card_list')

                    <div class="card-text">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="md-form">
                                <label for="email">メールアドレス</label>
                                <input type="text" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                            </div>
                            <div class="md-form">
                                <label for="password">パスワード</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <small>8文字以上で入力してください</small>
                            </div>
                            <input type="hidden" name="remember" id="remember" value="on">
                            <button class="btn btn-block cyan darken-1 text-white mt-2 mb-2" type="submit">
                                ログイン
                            </button>
                        </form>

                        <div class="mt-4 mb-5">
                            <a class="card-text" href="{{ route('register') }}">新規登録はこちら</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')

@endsection
