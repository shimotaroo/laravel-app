@extends('app')

@section('title', $user->name)

@section('content')
    @include('nav')
    <div class="row">
        <div class="container col-lg-6 col-md-8 col-sm-10 col-xs-12 mx-auto">
            <div class="card mt-5">
                <div class="card-body text-center">
                    <h2 class='h4 card-title text-center mt-5 mb-1'><span class="bg cyan darken-3 text-white py-3 px-4 rounded-pill">マイページ</span></h2>
                    <p class="mt-4">My Page</p>
                </div>
                <div class="card-body d-flex flex-row align-items-center mt-2 mb-3">
                    <div class="ml-4">
                        <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
                            <i class="fas fa-user-circle fa-3x"></i>
                        </a>
                    </div>
                    <h2 class="h5 card-title ml-3 mb-0">
                        <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
                            {{ $user->name }}
                        </a>
                    </h2>
                </div>
                {{-- <div class="card-body">
                    <div class="card-text">
                    <a href="" class="text-muted">
                        10 フォロー
                    </a>
                    <a href="" class="text-muted">
                        10 フォロワー
                    </a>
                    </div>
                </div> --}}
            </div>
            <ul class="nav nav-tabs nav-justified mt-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link text-muted active" id="post-articles" href="{{ route('users.show', ['name' => $user->name]) }}" data-toggle="tab" role="tab">
                        記事
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" id="like-articles" href="{{ route('users.show', ['name' => $user->name]) }}" data-toggle="tab" role="tab">
                        いいね
                    </a>
                </li>
            </ul>
            @foreach($articles as $article)
            <div class='card mt-5 col-10 mr-auto ml-auto p-0' id="post-articles">
                <div class='card-body d-flex flex-row align-items-center mt-3 ml-3'>
                    <i class="fas fa-file-alt fa-3x mr-3"></i>
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

            @foreach($articles as $article)
            <div class='card mt-5 col-10 mr-auto ml-auto p-0 id="like-articles"'>
                <div class='card-body d-flex flex-row align-items-center mt-3 ml-3'>
                    <i class="fas fa-file-alt fa-3x mr-3"></i>
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

        </div>
    </div>
    @include('footer')
@endsection
