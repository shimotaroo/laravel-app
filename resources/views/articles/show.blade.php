@extends('app')

@section('title', '面接情報詳細')

@section('content')

    @include('nav')

    <div class="container">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card mt-5 mb-5">
                    <div class="card-body pt-0 text-center">
                        <div class="card-body d-flex flex-row text-center">
                            <div class="card-body text-center">
                                <h2 class='h3 card-title text-center mt-5 mb-1'>面接情報詳細</h2>
                                <small>Detail</small>
                            </div>
                            @if( Auth::id() === $article->user_id)
                            <div class="ml-auto card-text">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <button type='button' class="btn btn-link text-muted m-0 p-2">
                                            <i class="fas fa-ellipsis-v fa-2x"></i>
                                        </button>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="{{ route('articles.edit', ['article' => $article]) }}" class="dropdown-item">
                                            <i class="fas fa-pen mr-1"></i>編集
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $article->id }}">
                                            <i class="fas fa-trash-alt mr-1"></i>削除
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

                        <div class="mt-2">
                            <div class="card-body d-flex flex-row">
                                <div class="card-body">
                                    <div class="card-body">ユーザー名</div>
                                    <div class="card-body">{{ $article->user->name }}</div>
                                </div>
                                <div class="card-body">
                                    <div class="card-body">投稿日時</div>
                                    <div class="card-body">{{ $article->created_at->format('Y/m/d') }}</div>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-row">
                                <div class="card-body">
                                    <div class="card-body">エリア</div>
                                    <div class="card-body">{{ $article->prefecture->prefecture }}</div>
                                </div>
                                <div class="card-body">
                                    <div class="card-body">事業形態</div>
                                    <div class="card-body">{{  $article->companyType->company_type }}</div>
                                </div>
                                <div class="card-body">
                                    <div class="card-body">選考フェーズ</div>
                                    <div class="card-body">{{  $article->phase->phase }}</div>
                                </div>
                            </div>

                            <div class="card-body d-flex flex-row">
                                <div class="card-body">質問項目</div>
                                <div class="card-body">{!! nl2br(e($article->question_content)) !!}</div>
                            </div>
                            <div class="card-body d-flex flex-row">
                                <div class="card-body">その他情報</div>
                                <div class="card-body">{!! nl2br(e($article->other_information)) !!}</div>
                            </div>
                            <div class="card-body d-flex flex-row">
                                <div class="card-body">所感・アドバイス等</div>
                                <div class="card-body">{!! nl2br(e($article->impression)) !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')

@endsection
