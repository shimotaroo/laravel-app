@extends('app')

@section('title', '投稿一覧')

@section('content')
    @include('nav')
    <div class="row">

        <div class="col-lg-4 col-md-5 col-sm-6 col-xs-6 mt-5 pl-5">
            @include('sidenav')
        </div>

        <div class='col-lg-7 col-md-5 col-sm-6 col-xs-6 mt-5 mr-auto ml-5'>
            <div class='row mt-5 col-lg-8 col-md-8 col-sm-12 col-xs-12 p-0'>
                <div class="col-6">
                    <small class="ml-3">
                        並び順<i class="fas fa-angle-double-right mx-2"></i>{{ $sort }}
                    </small>
                </div>
                {{-- <div class="col-6 text-right">
                    <small class="mr-1">
                        全{{ $articles_count }}件
                    </small>
                </div> --}}
                @if (isset($search_condition_for_prefecture))
                    <div class="col-12">
                        <small class="ml-3">
                            検索条件<i class="fas fa-angle-double-right mx-2"></i>都道府県：{{ $search_condition_for_prefecture }}、事業形態：{{ $search_condition_for_company }}、フェーズ：{{ $search_condition_for_phase }}
                        </small>
                    </div>
                @endif
            </div>
            @if(!empty($articles->toArray()['data']))
                @foreach($articles as $article)
                    <div class='card mt-3 col-lg-8 col-md-8 col-sm-12 col-xs-12 p-0'>
                        <div class='card-body d-flex flex-row align-items-center mt-3 ml-3'>
                            <img src="{{ $article->user->image }}" alt="Contact Person" class="img-fuild rounded-circle mr-3" width="60" height="60">
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

                        <div class='card-body'>
                            <div class='d-flex flex-row'>
                                <div class="mr-3">
                                    <p class="bg orange lighten-1 text-white px-3 py-2 rounded-pill ml-4">都道府県</p>
                                </div>
                                <div>
                                    <p class="py-2">{{ $article->prefecture->prefecture }}</p>
                                </div>
                            </div>
                            <div class='d-flex flex-row'>
                                <div class="mr-3">
                                    <p class="bg orange lighten-1 text-white px-3 py-2 rounded-pill ml-4">事業形態</p>
                                </div>
                                <div>
                                    <p class="py-2">{{ $article->companyType->company_type }}</p>
                                </div>
                            </div>
                            <div class='d-flex flex-row'>
                                <div class="mr-3">
                                    <p class="bg orange lighten-1 text-white px-3 py-2 rounded-pill ml-4">フェーズ</p>
                                </div>
                                <div>
                                    <p class="py-2">{{ $article->phase->phase }}</p>
                                </div>
                            </div>
                            <a class='btn grey darken-2 mt-3 text-white ml-4' href="{{ route('articles.show', ['article' => $article]) }}">詳しく見る<i class="fas fa-angle-double-right ml-2"></i></a>
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
            @else
                <div class='mt-5 text-center col-lg-8 col-md-8 col-sm-12 col-xs-12 p-0'>
                    <div class="mt-5">
                        <p class="mt-5">
                            検索条件に合う記事がありません
                        </p>
                        <a class='btn cyan darken-3 text-white waves-effect' href="{{ route('articles.index') }}">検索条件を解除する</a>
                    </div>
                </div>
            @endif

            <div class="mt-5 mb-3 col-lg-8 col-md-8 col-sm-12 col-xs-12 p-0 d-flex justify-content-center">
                @if(isset($sort_type))
                    {{ $articles->appends($sort_type)->links() }}
                @elseif(isset($search_conditions))
                    {{ $articles->appends(request()->input())->links() }}
                @else
                    {{ $articles->links() }}
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-0 col-xs-0"></div>
    @include('footer')
@endsection
