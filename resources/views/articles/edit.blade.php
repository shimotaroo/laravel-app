@extends('app')

@section('title', '面接情報編集')

@section('content')

    @include('nav')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mt-5 mb-3">
                    <div class="card-body text-center">
                        <h2 class='h4 card-title text-center mt-5 mb-1'><span class="bg cyan darken-3 text-white py-3 px-4 rounded-pill">面接情報を編集する</span></h2>
                        <p class="mt-4">Edit</p>

                        @include('error_card_list')

                        <div class="mt-5">
                            <form action="{{ route('articles.update', ['article' => $article]) }}" method="POST">
                                @method('PATCH')
                                @include('articles.form')
                                <button type="submit" class="btn btn-block cyan darken-1 text-white mt-4 mb-2">
                                    更新する
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')

@endsection
