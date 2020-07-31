@extends('app')

@section('title', 'パスワード再設定')

@section('content')

    @include('nav')

    <div class="row">
        <div class="mx-auto col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6">
            <div class="card mt-5">
                <div class="card-body text-center">
                    <h2 class='h4 card-title text-center mt-5 mb-1'><span class="bg cyan darken-3 text-white py-3 px-4 rounded-pill">パスワード変更</span></h2>
                    <p class="mt-4">Password Edit</p>

                    @include('error_card_list')

                    <div class="card-text mt-5">
                        <form method="POST" action="{{ route('users.password.update', ['name' => $user->name]) }}">
                            @method('PATCH')
                            @csrf

                            {{-- <input type="hidden" name="email" value={{ $email }}>
                            <input type="hidden" name="token" value={{ $token }}> --}}
                            <div class="md-form col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-3">
                                <label for="old_password">現在のパスワード</label>
                                <input type="password" class="form-control" id="old_password" name="current_password" required>
                                <small>ご登録のパスワードを入力ください</small>
                            </div>
                            <div class="md-form col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-3">
                                <label for="password">新しいパスワード</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <small>8文字以上で入力してください</small>
                            </div>
                            <div class="md-form col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-3">
                                <label for="password_confirmation">新しいパスワード（確認）</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                <small>パスワードを再入力してください</small>
                            </div>
                            <button class="btn btn-block cyan darken-3 text-white col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-4 mb-5" type="submit">
                                変更する
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')

@endsection
