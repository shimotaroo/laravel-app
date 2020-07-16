@extends('app')

@section('title', '投稿一覧')

@section('content')
    @include('nav')
    <div class='container'>
        @foreach($articles as $article)
            <div class='card mt-3'>
                <div class='card-body d-flex flex-row'>
                    <i class="fas fa-file-alt fa-3x mr-3"></i>
                    <div>
                        <div class='font-weight-bold'>
                            {{ $article->user->name }}
                        </div>
                        <div class='font-weight-lighter'>
                            {{ $article->created_at->format('Y/m/d') }}
                        </div>
                    </div>
                </div>

                <div class='card-body pt-0 pb-2'>
                    <h3 class='h5 card-title'>
                        都道府県：{{ $article->prefecture->prefecture }}
                    </h3>
                    <h3 class='h5 card-title'>
                        タイプ：{{  $article->companyType->company_type }}
                    </h3>
                    <h3 class='h5 card-title'>
                        選考フェーズ：{{  $article->phase->phase }}
                    </h3>
                    <a class='btn btn-outline-info waves-effect' href="">Read More</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
