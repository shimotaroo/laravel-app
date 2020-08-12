@extends('app')

@section('title', '面接情報投稿')

@section('content')

    @include('nav')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-md-12 mx-auto my-5">
                <div class="card mt-5 mb-5">
                    <div class="card-body text-center">
                        <h2 class='h4 card-title text-center mt-5 mb-1'><span class="bg cyan darken-3 text-white py-3 px-4 rounded-pill">面接情報投稿</span></h2>
                        <p class="mt-4">New Post</p>

                        @include('error_card_list')

                        <div class="mt-5">
                            <form action="{{ route('articles.store') }}" method="POST">
                                @include('articles.form')
                                <button type="submit" class="btn btn-block cyan darken-3 text-white col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto mt-5 mb-5">
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
