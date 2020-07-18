@extends('app')

@section('title', $user->name)

@section('content')
    @include('nav')
    <div class="container">
        <div class="card mt-3">
            <div class="card-body">
                <div class="d-flex flex-row">
                <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
                    <i class="fas fa-user-circle fa-3x"></i>
                </a>
                </div>
                <h2 class="h5 card-title m-0">
                <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
                    {{ $user->name }}
                </a>
                </h2>
            </div>
            <div class="card-body">
                <div class="card-text">
                <a href="" class="text-muted">
                    10 フォロー
                </a>
                <a href="" class="text-muted">
                    10 フォロワー
                </a>
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs nav-justified mt-3">
            <li class="nav-item">
                <a class="nav-link text-muted active" href="{{ route('users.show', ['name' => $user->name]) }}">
                    記事
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-muted" href="">
                    いいね
                </a>
            </li>
        </ul>
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
