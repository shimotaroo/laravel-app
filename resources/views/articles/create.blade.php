@extends('app')

@section('title', '面接情報投稿')

@section('content')

    @include('nav')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mt-5 mb-5">
                    <div class="card-body pt-0 text-center">
                        <h2 class='h3 card-title text-center mt-5 mb-1'>面接情報投稿</h2>
                        <small>Post</small>

                        @include('error_card_list')

                        <div class="mt-5">
                            <form action="{{ route('articles.store') }}" method="POST">
                                @include('articles.form')
                                <button type="submit" class="btn btn-block btn-outline-info waves-effect mt-4 mb-2">
                                    投稿する
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
