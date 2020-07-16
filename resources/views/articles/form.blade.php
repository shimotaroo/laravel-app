@csrf

<div class="mb-4">
    <span class="mr-3">エリア</span>
    <div class="form-check form-check-inline">
        <input type="radio" name='prefecture_id' id="prefecture1" class='form-check-input' value=1>
        <label class="form-check-label" for="prefecture1">東京</label>
    </div>
    <div class="form-check form-check-inline">
        <input type="radio" name='prefecture_id' id="prefecture2" class='form-check-input' value=2>
        <label class="form-check-label" for="prefecture2">大阪</label>
    </div>
    <div class="form-check form-check-inline">
        <input type="radio" name='prefecture_id' id="prefecture3" class='form-check-input' value=3>
        <label class="form-check-label" for="prefecture3">福岡</label>
    </div>
</div>

<div class="mb-4">
    <span class="mr-3">事業形態</span>
    <div class="form-check form-check-inline">
        <input type="radio" name='company_type_id' id="company1" class='form-check-input' value=1>
        <label class="form-check-label" for="company1">自社開発企業</label>
    </div>
    <div class="form-check form-check-inline">
        <input type="radio" name='company_type_id' id="company2" class='form-check-input' value=2>
        <label class="form-check-label" for="company2">受託開発企業</label>
    </div>
    <div class="form-check form-check-inline">
        <input type="radio" name='company_type_id' id="company3" class='form-check-input' value=3>
        <label class="form-check-label" for="company3">SES</label>
    </div>
</div>

<div class="mb-4">
    <span class="mr-3">選考フェーズ</span>
    <div class="form-check form-check-inline">
        <input type="radio" name='phase_id' id="phase1" class='form-check-input' value=1>
        <label class="form-check-label" for="phase1">1次面接</label>
    </div>
    <div class="form-check form-check-inline">
        <input type="radio" name='phase_id' id="phase2" class='form-check-input' value=2>
        <label class="form-check-label" for="phase2">2次面接</label>
    </div>
    <div class="form-check form-check-inline">
        <input type="radio" name='phase_id' id="phase3" class='form-check-input' value=3>
        <label class="form-check-label" for="phase3">最終面接</label>
    </div>
</div>

<div class="form-group text-left">
    <label>面接で聞かれた質問</label>
    <textarea name="question_content" class="form-control" required rows="10" placeholder="(例)・なぜエンジニアになろうと思ったのか">{{ old('question_content') }}</textarea>
</div>

<div class="form-group text-left">
    <label>その他情報</label>
    <textarea name="other_information" class="form-control" required rows="10" placeholder="(例)・面接担当は人事1名、エンジニア1名">{{ old('other_information') }}</textarea>
</div>

<div class="form-group text-left">
    <label>所感・アドバイス等</label>
    <textarea name="impression" class="form-control" required rows="10" placeholder="(例)・転職理由を答える際はネガティブな内容にならないように気をつける">{{ old('question_content') }}</textarea>
</div>

