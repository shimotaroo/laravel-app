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
                    <a class='btn cyan darken-1 text-white' href="{{ route('articles.show', ['article' => $article]) }}">Read More</a>
                </div>
            </div>
        @endforeach
    </div>
    @include('footer')
@endsection
