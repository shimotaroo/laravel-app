@extends('app')

@section('title', '投稿一覧')

@section('content')
    @include('nav')
    <div class='container'>

        @foreach($articles as $article)
            <div class='card mt-5 col-xs-12 col-lg-6 col-md-8 col-sm-10  mr-auto ml-auto p-0'>
                <div class='card-body d-flex flex-row align-items-center mt-3 ml-3'>
                    <img src="{{ asset('storage/'.$article->user->image) }}" alt="Contact Person" class="img-fuild rounded-circle mr-3" width="60" height="60">
                    <div>
                        <h5 class='font-weight-bold'>
                            {{ $article->user->name }}
                        </h5>
                        <div>
                            <i class="far fa-clock pr-1"></i>{{ $article->created_at->format('Y/m/d') }}
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
                                    <a href="{{ route('articles.edit', ['article' => $article]) }}" class="dropdown-item">
                                        <i class="fas fa-pen mr-1"></i>編集する
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $article->id }}">
                                        <i class="fas fa-trash-alt mr-1"></i>削除する
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

                <div class='card-body'>
                    <div class='d-flex flex-row'>
                        <div class="mr-3">
                            <p class="bg cyan text-white px-3 py-2 rounded-pill">都道府県</p>
                        </div>
                        <div>
                            <p class="py-2">{{ $article->prefecture->prefecture }}</p>
                        </div>
                    </div>
                    <div class='d-flex flex-row'>
                        <div class="mr-3">
                            <p class="bg cyan text-white px-3 py-2 rounded-pill">事業形態</p>
                        </div>
                        <div>
                            <p class="py-2">{{ $article->companyType->company_type }}</p>
                        </div>
                    </div>
                    <div class='d-flex flex-row'>
                        <div class="mr-3">
                            <p class="bg cyan text-white px-3 py-2 rounded-pill">フェーズ</p>
                        </div>
                        <div>
                            <p class="py-2">{{ $article->phase->phase }}</p>
                        </div>
                    </div>
                    <a class='btn btn-outline-default waves-effect mt-3' href="{{ route('articles.show', ['article' => $article]) }}">詳しく見る</a>
                </div>
                <div class='card-body pt-0 pb-2 pl-3 mb-3 ml-3'>
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
            </div>
        @endforeach
        <div class="mt-5 mb-3 d-flex justify-content-center">
            {{ $articles->links() }}
        </div>
    </div>
    @include('footer')
@endsection
