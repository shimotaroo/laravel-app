@extends('app')

@section('title', 'プロフィール編集')

@section('content')
    @include('nav')
    <div class="row">
        <div class="container col-lg-6 col-md-8 col-sm-10 col-xs-11 mx-auto">
            <div class="card mt-5">
                <div class="card-body text-center">
                    <h2 class='h4 card-title text-center mt-5 mb-1'><span class="bg cyan darken-3 text-white py-3 px-4 rounded-pill">プロフィール編集</span></h2>
                    <p class="mt-4">Profile Edit</p>
                </div>

                @include('error_card_list')

                <div class="mt-2">
                        <div class="card-body align-items-center text-center mt-2 mb-3">
                            <form action="{{ route('users.update', ['name' => $user->name]) }}" method="POST" enctype="multipart/form-data">
                                @method('PATCH')
                                @csrf
                                {{-- 編集フォーム --}}
                                <label for="image">
                                    <img src="{{ asset('storage/'.$user->image) }}" id="img" class="img-fuild rounded-circle" width="80" height="80">
                                    <input type="file" id="image" name="image" onchange="previewImage(this);" class="d-none">
                                </label>
                                <div class="md-form col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto">
                                    <label for="name">ユーザー名</label>
                                    <input type="text" class="form-control" id="name" name="name" required value="{{ $user->name }}">
                                    <small>3〜15文字で入力してください</small>
                                </div>
                                <div class="md-form col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto">
                                    <label for="age">年齢</label>
                                    <input type="text" class="form-control" id="age" name="age" value="{{ $user->age }}">
                                </div>
                                <div class="md-form col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto">
                                    <label for="email">メールアドレス</label>
                                    <input type="text" class="form-control" id="email" name="email" required value="{{ $user->email }}">
                                </div>
                                <button type="submit" class="btn btn-block cyan darken-3 text-white col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-5 waves-effect">
                                    更新する
                                </button>
                                <div class="mx-auto">
                                    <a class='btn btn-amber col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-3 mb-5 waves-effect waves-effect' href="{{ route('users.password.edit', ['name' => $user->name]) }}">パスワード変更はこちら</a>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
@endsection

<script>
    function previewImage(obj)
    {
        var fileReader = new FileReader();
        fileReader.onload = (function() {
            document.querySelector('#img').src = fileReader.result;
        });
        fileReader.readAsDataURL(obj.files[0]);
    }
</script>
