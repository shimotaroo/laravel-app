@extends('app')

@section('title', $user->name)

@section('content')
    @include('nav')
    <div class="row">
        <div class="container col-lg-6 col-md-8 col-sm-10 col-xs-11 mx-auto">
            <div class="card mt-5">
                <div class="card-body text-center">
                    <h2 class='h4 card-title text-center mt-5 mb-1'><span class="bg cyan darken-3 text-white py-3 px-4 rounded-pill">マイページ</span></h2>
                    <p class="mt-4">My Page</p>
                </div>

                <div class="card-body d-flex flex-row align-items-center mt-2 mb-3">
                    <div class="ml-4">
                        <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
                            <img src="{{ asset('storage/'.$user->image) }}" alt="Contact Person" class="img-fuild rounded-circle" width="60" height="60">
                        </a>
                    </div>
                    <h2 class="h5 card-title ml-3 mb-0">
                        <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
                            {{ $user->name }}
                        </a>
                    </h2>
                    <div class="ml-auto">
                        <a class='btn btn-amber rounded-pill waves-effect' href="{{ route('users.edit', ['name' => $user->name]) }}">編集</a>
                    </div>
                </div>
            </div>
            <div class="card mt-5 pb-5">
                {{-- タブ --}}
                <ul class="nav nav-tabs nav-justified md-tabs" id="myTabJust" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active text-dark" id="post-articles-tab-just" data-toggle="tab" href="#post-articles-just" role="tab" aria-controls="post-articles-just"
                        aria-selected="true">自分の投稿</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" id="like-articles-tab-just" data-toggle="tab" href="#like-articles-just" role="tab" aria-controls="like-articles-just"
                        aria-selected="false">いいねした投稿</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContentJust">
                    {{-- 投稿した記事 --}}
                    <div class="tab-pane fade show active" id="post-articles-just" role="tabpanel" aria-labelledby="post-articles-tab-just">
                        @foreach($postArticles as $postArticle)
                        <div class='card mt-5 col-10 mr-auto ml-auto p-0'>
                            <div class='card-body d-flex flex-row align-items-center mt-3 ml-3'>
                                <img src="{{ asset('storage/'.$user->image) }}" alt="Contact Person" class="img-fuild rounded-circle mr-3" width="60" height="60">
                                <div>
                                    <h5 class='font-weight-bold'>
                                        {{ $postArticle->user->name }}
                                    </h5>
                                    <div>
                                        <i class="far fa-clock pr-1"></i>{{ $postArticle->created_at->format('Y/m/d') }}
                                    </div>
                                </div>

                                @if( Auth::id() === $postArticle->user_id)
                                    <div class="ml-auto card-text">
                                        <div class="dropdown">
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <button type='button' class="btn btn-link text-muted m-0 p-2">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{ route('articles.edit', ['article' => $postArticle]) }}" class="dropdown-item text-center">
                                                    <i class="fas fa-pen mr-1"></i>編集する
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger text-center" data-toggle="modal" data-target="#modal-delete-{{ $postArticle->id }}">
                                                    <i class="fas fa-trash-alt mr-1"></i>削除する
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id='modal-delete-{{ $postArticle->id }}' class="modal fade" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type='button' class="close" data-dismiss="modal" aria-label="閉じる">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form method='POST' action="{{ route('articles.destroy', ['article' => $postArticle]) }}">
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
                                        <p class="py-2">{{ $postArticle->prefecture->prefecture }}</p>
                                    </div>
                                </div>
                                <div class='d-flex flex-row'>
                                    <div class="mr-3">
                                        <p class="bg cyan text-white px-3 py-2 rounded-pill">事業形態</p>
                                    </div>
                                    <div>
                                        <p class="py-2">{{ $postArticle->companyType->company_type }}</p>
                                    </div>
                                </div>
                                <div class='d-flex flex-row'>
                                    <div class="mr-3">
                                        <p class="bg cyan text-white px-3 py-2 rounded-pill">フェーズ</p>
                                    </div>
                                    <div>
                                        <p class="py-2">{{ $postArticle->phase->phase }}</p>
                                    </div>
                                </div>
                                <a class='btn btn-outline-default waves-effect mt-3' href="{{ route('articles.show', ['article' => $postArticle]) }}">詳しく見る</a>
                            </div>
                            <div class='card-body pt-0 pb-2 pl-3 mb-3 ml-3'>
                                <div class="card-text">
                                    <article-like
                                        :initial-is-liked-by-user='@json($postArticle->isLikedByUser(Auth::user()))'
                                        :initial-count-likes='@json($postArticle->count_likes)'
                                        :authorized='@json(Auth::check())'
                                        endpoint="{{ route('articles.like', ['article' => $postArticle]) }}"
                                    >
                                    </article-like>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- いいねした記事 --}}
                    <div class="tab-pane fade" id="like-articles-just" role="tabpanel" aria-labelledby="like-articles-tab-just">
                        @foreach($likeArticles as $likeArticle)
                        <div class='card mt-5 col-10 mr-auto ml-auto p-0'>
                            <div class='card-body d-flex flex-row align-items-center mt-3 ml-3'>
                                <img src="{{ asset('storage/'.$user->image) }}" alt="Contact Person" class="img-fuild rounded-circle mr-3" width="60" height="60">
                                <div>
                                    <h5 class='font-weight-bold'>
                                        {{ $likeArticle->user->name }}
                                    </h5>
                                    <div>
                                        <i class="far fa-clock pr-1"></i>{{ $likeArticle->created_at->format('Y/m/d') }}
                                    </div>
                                </div>

                                @if( Auth::id() === $likeArticle->user_id)
                                    <div class="ml-auto card-text">
                                        <div class="dropdown">
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <button type='button' class="btn btn-link text-muted m-0 p-2">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{ route('articles.edit', ['article' => $likeArticle]) }}" class="dropdown-item text-center">
                                                    <i class="fas fa-pen mr-1"></i>編集する
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger text-center" data-toggle="modal" data-target="#modal-delete-{{ $likeArticle->id }}">
                                                    <i class="fas fa-trash-alt mr-1"></i>削除する
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id='modal-delete-{{ $likeArticle->id }}' class="modal fade" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type='button' class="close" data-dismiss="modal" aria-label="閉じる">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form method='POST' action="{{ route('articles.destroy', ['article' => $likeArticle]) }}">
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
                                        <p class="py-2">{{ $likeArticle->prefecture->prefecture }}</p>
                                    </div>
                                </div>
                                <div class='d-flex flex-row'>
                                    <div class="mr-3">
                                        <p class="bg cyan text-white px-3 py-2 rounded-pill">事業形態</p>
                                    </div>
                                    <div>
                                        <p class="py-2">{{ $likeArticle->companyType->company_type }}</p>
                                    </div>
                                </div>
                                <div class='d-flex flex-row'>
                                    <div class="mr-3">
                                        <p class="bg cyan text-white px-3 py-2 rounded-pill">フェーズ</p>
                                    </div>
                                    <div>
                                        <p class="py-2">{{ $likeArticle->phase->phase }}</p>
                                    </div>
                                </div>
                                <a class='btn btn-outline-default waves-effect mt-3' href="{{ route('articles.show', ['article' => $likeArticle]) }}">詳しく見る</a>
                            </div>
                            <div class='card-body pt-0 pb-2 pl-3 mb-3 ml-3'>
                                <div class="card-text">
                                    <article-like
                                        :initial-is-liked-by-user='@json($likeArticle->isLikedByUser(Auth::user()))'
                                        :initial-count-likes='@json($likeArticle->count_likes)'
                                        :authorized='@json(Auth::check())'
                                        endpoint="{{ route('articles.like', ['article' => $likeArticle]) }}"
                                    >
                                    </article-like>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
@endsection
