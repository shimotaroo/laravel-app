@csrf

<div class="mb-4 col-lg-5 col-md-6 col-sm-8 col-xs-10 mx-auto row align-items-center ">
    <span class="col-3 text-center bg cyan text-white px-3 py-2 rounded-pill">都道府県</span>
    <div class="col-9 text-left py-2 ">
        <div class="form-check form-check-inline">
            <input type="radio" name='prefecture_id' id="prefecture1" class='form-check-input' value=1 {{ old('prefecture_id') == 1 ? 'checked' : '' }} {{ is_null($article) ? '' : $article->prefecture_id == 1 ? 'checked' : ''}}>
            <label class="form-check-label" for="prefecture1">東京</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="radio" name='prefecture_id' id="prefecture2" class='form-check-input' value=2 {{ old('prefecture_id') == 2 ? 'checked' : '' }} {{ is_null($article) ? '' : $article->prefecture_id == 2 ? 'checked' : ''}}>
            <label class="form-check-label" for="prefecture2">大阪</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="radio" name='prefecture_id' id="prefecture3" class='form-check-input' value=3 {{ old('prefecture_id') == 3 ? 'checked' : '' }} {{ is_null($article) ? '' : $article->prefecture_id == 3 ? 'checked' : ''}}>
            <label class="form-check-label" for="prefecture3">福岡</label>
        </div>
    </div>
</div>

<div class="mb-4 col-lg-5 col-md-6 col-sm-8 col-xs-10 mx-auto row align-items-center ">
    <span class="col-3 text-center bg cyan text-white px-3 py-2 rounded-pill">事業形態</span>
    <div class="col-9 text-left">
        <div class="form-check form-check-inline">
            <input type="radio" name='company_type_id' id="company1" class='form-check-input' value=1 {{ old('company_type_id') == 1 ? 'checked' : '' }} {{ is_null($article) ? '' : $article->company_type_id == 1 ? 'checked' : ''}}>
            <label class="form-check-label" for="company1">自社開発企業</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="radio" name='company_type_id' id="company2" class='form-check-input' value=2 {{ old('company_type_id') == 2 ? 'checked' : '' }} {{ is_null($article) ? '' : $article->company_type_id == 2 ? 'checked' : ''}}>
            <label class="form-check-label" for="company2">受託開発企業</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="radio" name='company_type_id' id="company3" class='form-check-input' value=3 {{ old('company_type_id') == 3 ? 'checked' : '' }} {{ is_null($article) ? '' : $article->company_type_id == 3 ? 'checked' : ''}}>
            <label class="form-check-label" for="company3">SES</label>
        </div>
    </div>
</div>

<div class="mb-4 col-lg-5 col-md-6 col-sm-8 col-xs-10 mx-auto row align-items-center ">
    <span class="col-3 text-center bg cyan text-white px-3 py-2 rounded-pill">フェーズ</span>
    <div class="col-9 text-left">
        <div class="form-check form-check-inline">
            <input type="radio" name='phase_id' id="phase1" class='form-check-input' value=1 {{ old('phase_id_id') == 1 ? 'checked' : '' }} {{ is_null($article) ? '' : $article->phase_id == 1 ? 'checked' : ''}}>
            <label class="form-check-label" for="phase1">1次面接</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="radio" name='phase_id' id="phase2" class='form-check-input' value=2 {{ old('phase_id_id') == 2 ? 'checked' : '' }} {{ is_null($article) ? '' : $article->phase_id == 2 ? 'checked' : ''}}>
            <label class="form-check-label" for="phase2">2次面接</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="radio" name='phase_id' id="phase3" class='form-check-input' value=3 {{ old('phase_id_id') == 3 ? 'checked' : '' }} {{ is_null($article) ? '' : $article->phase_id == 3 ? 'checked' : ''}}>
            <label class="form-check-label" for="phase3">最終面接</label>
        </div>
    </div>
</div>

<div class="card-body form-group text-left col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-5">
    <label class="bg cyan text-white px-3 py-2 rounded-pill mb-3">面接で聞かれた質問</label>
    <textarea name="question_content" class="form-control" required rows="10" placeholder="(例)・なぜエンジニアになろうと思ったのか">{{ $article->question_content ?? old('question_content') }}</textarea>
</div>

<div class="card-body form-group text-left col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-5">
    <label class="bg cyan text-white px-3 py-2 rounded-pill mb-3">その他情報</label>
    <textarea name="other_information" class="form-control" required rows="10" placeholder="(例)・面接担当は人事1名、エンジニア1名">{{ $article->other_information ?? old('other_information') }}</textarea>
</div>

<div class="card-body form-group text-left col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-5">
    <label class="bg cyan text-white px-3 py-2 rounded-pill mb-3">所感・アドバイス等</label>
    <textarea name="impression" class="form-control" required rows="10" placeholder="(例)・転職理由を答える際はネガティブな内容にならないように気をつける">{{ $article->question_content ?? old('question_content') }}</textarea>
</div>

