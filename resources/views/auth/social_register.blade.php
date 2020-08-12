@extends('app')

@section('title', '新規登録')

@section('content')

    @include('nav')

    <div class="row">
        <div class="mx-auto col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6 my-5">
            <div class="card mt-5">
                <div class="card-body text-center">
                    <h2 class='h4 card-title text-center mt-5 mb-1'><span class="bg cyan darken-3 text-white py-3 px-5 rounded-pill">ユーザー登録</span></h2>
                    <p class="mt-4">Sign Up</p>

                    @include('error_card_list')

                    <div class="card-text">
                        <form method="POST" action="{{ route('register.{provider}', ['provider' => $provider]) }}">
                            @csrf
                            <input type="hidden" name='token' value="{{ $token }}">　
                            @if ( $provider === 'twitter')
                                <input type="hidden" name='tokenSecret' value="{{ $tokenSecret }}">　
                            @endif
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
                                <label for="email">メールアドレス</label>
                                <input type="text" class="form-control" id="email" name="email" value="{{ $email }}" disabled>
                            </div>
                            <button class="btn btn-block cyan darken-3 text-white col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto my-5" type="submit">
                                {{ $provider }}アカウントで登録する
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')

@endsection
