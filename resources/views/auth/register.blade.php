@extends('app')

@section('title', '新規登録')

@section('content')

    @include('nav')

    <div class="row">
        <div class="mx-auto col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6">
            <div class="card mt-5">
                <div class="card-body text-center">
                    <h2 class='h3 card-title text-center mt-2 mb-1'>新規登録</h2>
                    <small>sign up</small>

                    @include('error_card_list')

                    <div class="card-text">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="md-form">
                                <label for="name">ユーザー名</label>
                                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
                                <small>3〜15文字で入力してください</small>
                            </div>
                            <div class="md-form">
                                <label for="age">年齢</label>
                                <input type="text" class="form-control" id="age" name="age" value="{{ old('age') }}">
                            </div>
                            <div class="md-form">
                                <label for="email">メールアドレス</label>
                                <input type="text" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                            </div>
                            <div class="md-form">
                                <label for="password">パスワード</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <small>8文字以上で入力してください</small>
                            </div>
                            <div class="md-form">
                                <label for="password_confirmation">パスワード（確認）</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                <small>パスワードを再入力してください</small>
                            </div>
                            <button class="btn btn-block btn-outline-info waves-effect mt-2 mb-2" type="submit">
                                登録する
                            </button>
                        </form>

                        <div class="mt-4">
                            <a class="card-text" href="{{ route('login') }}">ログインはこちら</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')

@endsection
