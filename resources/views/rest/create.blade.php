@extends('app')

@section('title', 'APIによる投稿・削除')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-md-12 mx-auto my-5">
                <div class="card mt-5 mb-5">
                    <div class="card-body text-center">
                        <h2 class='h4 card-title text-center mt-5 mb-1'><span class="bg cyan darken-3 text-white py-3 px-4 rounded-pill">APIによる投稿・削除</span></h2>
                        <p class="mt-4">Post and Delete by API</p>

                        @include('error_card_list')

                        <div class="mt-5">
                            <form action="{{ route('rest.store') }}" method="POST">
                                @csrf
                                <div class="mb-4 col-lg-7 col-md-8 col-sm-9 col-xs-10 mx-auto row align-items-center ">
                                    <span class="col-3 text-center bg orange lighten-1 text-white px-3 py-2 rounded-pill">都道府県</span>
                                    <div class="col-9 text-left py-2 ">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name='prefecture_id' id="prefecture1" class='form-check-input' value=1 {{ old('prefecture_id') == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="prefecture1">東京</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name='prefecture_id' id="prefecture2" class='form-check-input' value=2 {{ old('prefecture_id') == 2 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="prefecture2">大阪</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name='prefecture_id' id="prefecture3" class='form-check-input' value=3 {{ old('prefecture_id') == 3 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="prefecture3">福岡</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 col-lg-5 col-lg-7 col-md-8 col-sm-9 col-xs-10 mx-auto row align-items-center ">
                                    <span class="col-3 text-center bg orange lighten-1 text-white px-3 py-2 rounded-pill">事業形態</span>
                                    <div class="col-9 text-left">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name='company_type_id' id="company1" class='form-check-input' value=1 {{ old('company_type_id') == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="company1">自社開発企業</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name='company_type_id' id="company2" class='form-check-input' value=2 {{ old('company_type_id') == 2 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="company2">受託開発企業</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name='company_type_id' id="company3" class='form-check-input' value=3 {{ old('company_type_id') == 3 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="company3">SES</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 col-lg-5 col-lg-7 col-md-8 col-sm-9 col-xs-10 mx-auto row align-items-center ">
                                    <span class="col-3 text-center bg orange lighten-1 text-white px-3 py-2 rounded-pill">フェーズ</span>
                                    <div class="col-9 text-left">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name='phase_id' id="phase1" class='form-check-input' value=1 {{ old('phase_id_id') == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="phase1">1次面接</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name='phase_id' id="phase2" class='form-check-input' value=2 {{ old('phase_id_id') == 2 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="phase2">2次面接</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name='phase_id' id="phase3" class='form-check-input' value=3 {{ old('phase_id_id') == 3 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="phase3">最終面接</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body form-group text-left col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-5">
                                    <label class="bg orange lighten-1 text-white px-3 py-2 rounded-pill mb-3">面接で聞かれた質問</label>
                                    <textarea name="question_content" class="form-control" required rows="8" placeholder="(例)・なぜエンジニアになろうと思ったのか">
                                        {{ old('question_content') }}
                                    </textarea>
                                </div>

                                <div class="card-body form-group text-left col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-4">
                                    <label class="bg orange lighten-1 text-white px-3 py-2 rounded-pill mb-3">その他情報</label>
                                    <textarea name="other_information" class="form-control" required rows="8" placeholder="(例)・面接担当は人事1名、エンジニア1名">
                                        {{ old('other_information') }}
                                    </textarea>
                                </div>

                                <div class="card-body form-group text-left col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-4">
                                    <label class="bg orange lighten-1 text-white px-3 py-2 rounded-pill mb-3">所感・アドバイス等</label>
                                    <textarea name="impression" class="form-control" required rows="8" placeholder="(例)・転職理由を答える際はネガティブな内容にならないように気をつける">
                                        {{ old('question_content') }}
                                    </textarea>
                                </div>
                                <button type="submit" class="btn btn-block cyan darken-3 text-white col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto mt-5 mb-5">
                                    <i class="fas fa-pen mr-1"></i>投稿する
                                </button>
                            </form>
                            @foreach ($articles as $article)
                                <form action="{{ route('rest.destroy', ['rest' => $article->id]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <div class="text-left col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto">名前：{{ $article->user->name }}</div>
                                    <div class="text-left col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto">都道府県：{{ $article->prefecture->prefecture }}</div>
                                    <div class="text-left col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto">事業形態：{{ $article->companyType->company_type }}</div>
                                    <div class="text-left col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto">フェーズ：{{ $article->phase->phase }}</div>
                                    <div class="text-left col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto">面接で聞かれた質問：{{ $article->question_content }}</div>
                                    <div class="text-left col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto">その他情報：{{ $article->other_information }}</div>
                                    <div class="text-left col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto">所感・アドバイス等：{{ $article->impression }}</div>
                                    <button type="submit" class="btn btn-block btn-danger text-white col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto mt-5 mb-5">
                                        <i class="fas fa-pen mr-1"></i>記事を削除する
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
