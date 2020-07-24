@extends('app')

@section('title', '面接情報投稿')

@section('content')

    @include('nav')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mt-5 mb-5">
                    <div class="card-body text-center">
                        <h2 class='h4 card-title text-center mt-5 mb-1'><span class="bg cyan darken-3 text-white py-3 px-4 rounded-pill">面接情報投稿</span></h2>
                        <p class="mt-4">New Post</p>

                        @include('error_card_list')

                        <div class="mt-5">
                            <form action="{{ route('articles.store') }}" method="POST">
                                @include('articles.form')
                                <button type="submit" class="btn btn-block cyan darken-3 text-white mt-4 mb-2 col-lg-5 col-md-6 col-sm-7 col-xs-8 mx-auto mb-4">
                                    <i class="fas fa-pen mr-1"></i>投稿する
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
