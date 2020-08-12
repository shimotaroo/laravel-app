@extends('app')

@section('title', 'ユーザー登録')

@section('content')

    @include('nav')

    <div class="row">
        <div class="mx-auto col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6 my-5">
            <div class="card mt-5">
                <div class="card-body text-center">
                    <h2 class='h4 card-title text-center mt-5 mb-1'><span class="bg cyan darken-3 text-white py-3 px-5 rounded-pill">ユーザー登録</span></h2>
                    <p class="mt-4">Sign Up</p>

                    <a href="{{ route('login.{provider}', ['provider' => 'google']) }}" class="btn btn-block red darken-1 text-white mt-4 mb-2 col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto">
                        <i class="fab fa-google mr-1"></i>Googleアカウントで登録
                    </a>
                    <a href="{{ route('login.{provider}', ['provider' => 'twitter']) }}" class="btn btn-block btn-info mb-4 col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto">
                        <i class="fab fa-twitter mr-1"></i>Twitterアカウントで登録
                    </a>

                    @include('error_card_list')

                    <div class="card-text">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="md-form col-lg-7 col-md-8 col-sm-9 col-xs-10 mx-auto">
                                <label for="name">ユーザー名<small class="text-warning ml-1">【必須】</small></label>
                                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
                                <small>※3〜15文字で入力してください</small>
                            </div>
                            <div class="md-form col-lg-7 col-md-8 col-sm-9 col-xs-10 mx-auto">
                                <label for="age">年齢</label>
                                <input type="text" class="form-control" id="age" name="age" value="{{ old('age') }}">
                            </div>
                            <div class="md-form col-lg-7 col-md-8 col-sm-9 col-xs-10 mx-auto">
                                <label for="email">メールアドレス<small class="text-warning ml-1">【必須】</small></label>
                                <input type="text" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                            </div>
                            <div class="md-form col-lg-7 col-md-8 col-sm-9 col-xs-10 mx-auto">
                                <label for="password">パスワード<small class="text-warning ml-1">【必須】</small></label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <small>※8文字以上で入力してください</small>
                            </div>
                            <div class="md-form col-lg-7 col-md-8 col-sm-9 col-xs-10 mx-auto">
                                <label for="password_confirmation">パスワード（確認）<small class="text-warning ml-1">【必須】</small></label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                <small>※確認のためパスワードを再入力してください</small>
                            </div>
                            <button class="btn btn-block cyan darken-3 text-white col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto mt-5" type="submit">
                                登録する
                            </button>
                        </form>

                        <a class="btn btn-block stylish-color-dark text-white col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto mb-5 mt-3" href="{{ route('login') }}">ログインはこちら</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')

@endsection
