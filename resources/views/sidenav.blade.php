{{-- 記事一覧並び替え --}}
<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 mx-auto mt-5">
    <h6 class="text-left">
        <i class="fas fa-sort mr-2"></i>並び替え
    </h6>
</div>
<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 mx-auto mt-3">
    <a class='btn btn-block grey text-white waves-effect rounded-pill' href="{{ route('articles.sort', ['sortType' => 'desc']) }}">新しい順<i class="fas fa-sort-amount-down ml-2"></i></a>
    <a class='btn btn-block grey text-white waves-effect rounded-pill mt-3' href="{{ route('articles.sort', ['sortType' => 'asc']) }}">古い順<i class="fas fa-sort-amount-up ml-2"></i></a>
    <a class='btn btn-block grey text-white waves-effect rounded-pill mt-3' href="{{ route('articles.sort', ['sortType' => 'like_count']) }}">いいね数順<i class="fas fa-heart ml-2"></i></a>
</div>
{{-- 記事一覧並び替え --}}

{{-- 絞り込み検索 --}}
<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 mx-auto mt-5">
    <h6 class="text-left">
        <i class="fas fa-search-plus mr-2"></i>絞り込み
    </h6>
</div>
<form action="{{ route('articles.search') }}" method="GET">
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto row mt-4">
        <div class="col-lg-6 col-md-12 mt-2 text-right">
            <span class="text-center bg grey text-white px-4 py-2 rounded-pill">都道府県</span>
        </div>
        <div class="col-lg-6 col-md-12 text-left mt-2">
            <div class="form-check form-check mb-1">
                <input type="radio" name='prefectureSearch' id="prefecture0" class='form-check-input' value=0 checked>
                <label class="form-check-label" for="prefecture0">指定なし</label>
            </div>
            @foreach ($prefecture as $id => $prefectureName)
                <div class="form-check form-check mb-1">
                    <input type="radio" name='prefectureSearch' id="prefecture{{ $id }}" class='form-check-input' value={{ $id }}>
                    <label class="form-check-label" for="prefecture{{ $id }}">{{ $prefectureName }}</label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto row mt-4">
        <div class="col-lg-6 col-md-12 mt-2 text-right">
            <span class="text-center bg grey text-white px-4 py-2 rounded-pill mr-2">事業形態</span>
        </div>
        <div class="col-lg-6 col-md-12 text-left mt-2">
            <div class="form-check form-check-inline mb-1">
                <input type="radio" name='companySearch' id="company0" class='form-check-input' value=0 checked>
                <label class="form-check-label" for="company0">指定なし</label>
            </div>
            @foreach ($companyType as $id => $type)
                <div class="form-check form-check-inline mb-1">
                    <input type="radio" name='companySearch' id="company{{ $id }}" class='form-check-input' value={{ $id }}>
                    <label class="form-check-label" for="company{{ $id }}">{{ $type }}</label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto row mt-4">
        <div class="col-lg-6 col-md-12 mt-2 text-right">
            <span class="text-center bg grey text-white px-4 py-2 rounded-pill mr-2">フェーズ</span>
        </div>
        <div class="col-lg-6 col-md-12 text-left mt-2">
            <div class="form-check form-check-inline mb-1">
                <input type="radio" name='phaseSearch' id="phase0" class='form-check-input' value=0 checked>
                <label class="form-check-label" for="phase0">指定なし</label>
            </div>
            @foreach ($phase as $id => $phaseType)
                <div class="form-check form-check-inline mb-1">
                    <input type="radio" name='phaseSearch' id="phase{{ $id }}" class='form-check-input' value={{ $id }}>
                    <label class="form-check-label" for="phase{{ $id }}">{{ $phaseType }}</label>
                </div>
            @endforeach
        </div>
    </div>
    <button type="submit" class="btn btn-block cyan darken-3 text-white mt-5 mb-2 col-lg-5 col-md-6 col-sm-7 col-xs-8 mx-auto mb-4">
        検索する
    </button>
</form>
{{-- 絞り込み検索 --}}
