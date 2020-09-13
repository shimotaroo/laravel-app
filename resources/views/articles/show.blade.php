@extends('app')

@section('title', '面接情報詳細')

@section('content')

    @include('nav')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-md-12 mx-auto my-5">
                <div class="card mt-5 mb-3">
                    <div class="card-body pt-0 text-center">
                        <div class="card-bodytext-center">
                            <div class="card-body text-center">
                                <h2 class='h4 card-title text-center mt-5 mb-1'><span class="bg cyan darken-3 text-white py-3 px-4 rounded-pill">面接情報詳細</span></h2>
                                <p class="mt-4">Detail</p>
                            </div>
                        </div>

                        <div class="mt-2 col-xs-12 col-md-10 mx-auto">
                            <div class="card-body d-flex flex-row">
                                <div class='card-body d-flex flex-row align-items-center mb-3'>
                                    <img src="{{ $user->image) }}" alt="Contact Person" class="img-fuild rounded-circle mr-3" width="60" height="60">
                                    <div>
                                        <h5 class='font-weight-bold'>
                                            {{ $article->user->name }}
                                        </h5>
                                        <div class="text-left">
                                            <i class="far fa-clock pr-1"></i>{{ $article->created_at->format('Y/m/d') }}
                                        </div>
                                    </div>
                                    <div class='ml-5'>
                                        <div class="card-text">
                                            <article-like
                                                :initial-is-liked-by-user='@json($article->isLikedByUser(Auth::user()))'
                                                :initial-count-likes='@json($article->count_likes)'
                                                :authorized='@json(Auth::check())'
                                                endpoint="{{ route('articles.like', ['article' => $article]) }}"
                                            >
                                            </article-like>
                                        </div>
                                    </div>

                                    @if( Auth::id() === $article->user_id)
                                        <div class="ml-auto card-text">
                                            <div class="dropdown">
                                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <button type='button' class="btn btn-link text-muted m-0 p-2">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="{{ route('articles.edit', ['article' => $article]) }}" class="dropdown-item text-center">
                                                        <i class="fas fa-pen mr-2"></i>編集する
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger text-center" data-toggle="modal" data-target="#modal-delete-{{ $article->id }}">
                                                        <i class="fas fa-trash-alt mr-2"></i>削除する
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id='modal-delete-{{ $article->id }}' class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type='button' class="close" data-dismiss="modal" aria-label="閉じる">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <form method='POST' action="{{ route('articles.destroy', ['article' => $article]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-body text-center">
                                                            こちらの記事を削除します。よろしいですか？<br>
                                                            （削除は取り戻せません）
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <a href="" class="btn btn-outline-grey" data-dismiss="modal">
                                                                キャンセル
                                                            </a>
                                                            <button type="submit" class="btn btn-danger">
                                                                削除する
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class='card-body'>
                                <div class='row'>
                                    <div class='d-flex flex-row col-xs-12 col-md-4'>
                                        <div class="mr-3">
                                            <p class="bg orange lighten-1 text-white px-3 py-2 rounded-pill">都道府県</p>
                                        </div>
                                        <div>
                                            <p class="py-2">{{ $article->prefecture->prefecture }}</p>
                                        </div>
                                    </div>
                                    <div class='d-flex flex-row col-xs-12 col-md-4'>
                                        <div class="mr-3">
                                            <p class="bg orange lighten-1 text-white px-3 py-2 rounded-pill">事業形態</p>
                                        </div>
                                        <div>
                                            <p class="py-2">{{ $article->companyType->company_type }}</p>
                                        </div>
                                    </div>
                                    <div class='d-flex flex-row col-xs-12 col-md-4'>
                                        <div class="mr-3">
                                            <p class="bg orange darken-1 text-white px-3 py-2 rounded-pill">フェーズ</p>
                                        </div>
                                        <div>
                                            <p class="py-2">{{ $article->phase->phase }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body text-left">
                                <div class="">
                                    <span class="bg orange lighten-1 text-white px-3 py-2 rounded-pill">質問項目</span>
                                </div>
                                <div class="card-body grey lighten-4 z-depth-1 mt-4 mb-3">{!! nl2br(e($article->question_content)) !!}</div>
                            </div>
                            <div class="card-body text-left">
                                <div class="">
                                    <span class="bg orange lighten-1 text-white px-3 py-2 rounded-pill">その他情報</span>
                                </div>
                                <div class="card-body grey lighten-4 z-depth-1 mt-4 mb-3">{!! nl2br(e($article->other_information)) !!}</div>
                            </div>
                            <div class="card-body text-left">
                                <div class="">
                                    <span class="bg orange lighten-1 text-white px-3 py-2 rounded-pill">所感・アドバイス等
                                    </span>
                                </div>
                                <div class="card-body grey lighten-4 z-depth-1 mt-4 mb-5">{!! nl2br(e($article->impression)) !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')

@endsection
