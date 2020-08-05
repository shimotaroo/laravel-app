<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    //ポリシーをコントローラーで使用できるようにする
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(3);
        $user = User::where('id', Auth::id())->first();

        //検索用のラジオボタン用のデータ
        $prefecture = config('forSerchByPrefecture');
        $companyType = config('forSerchByCompanyType');
        $phase = config('forSerchByPhase');

        return view('articles.index', [
            'articles' => $articles,
            'user' => $user,
            'prefecture' => $prefecture,
            'companyType' => $companyType,
            'phase' => $phase,
        ]);
    }

    //投稿画面
    public function create()
    {
        $article = null;
        $user = User::where('id', Auth::id())->first();
        return view('articles.create', [
            'article' => $article,
            'user' => $user,
        ]);
    }

    //投稿処理
    public function store(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all());
        $article->user_id = $request->user()->id;
        $article->save();
        return redirect()->route('articles.index');
    }

    //編集画面
    public function edit(Article $article)
    {
        return view('articles.edit', ['article' => $article]);
    }

    //編集処理
    public function update(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all())->save();
        return redirect()->route('articles.index');
    }

    //削除処理
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }

    //詳細画面
    public function show(Article $article)
    {
        return view('articles.show', ['article' => $article]);
    }

    //いいね機能
    public function like(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);
        $article->likes()->attach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    public function unlike(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    //記事一覧ページでの並び替え機能
    public function sort(string $sortType)
    {
        $user = User::where('id', Auth::id())->first();
        $Article = new Article;

        //検索用のラジオボタン用のデータ
        $prefecture = config('forSerchByPrefecture');
        $companyType = config('forSerchByCompanyType');
        $phase = config('forSerchByPhase');

        $data = [
            'articles' => $Article->sortByselectedSortType($sortType),
            'user' => $user,
            'sortType' => $sortType,
            'prefecture' => $prefecture,
            'companyType' => $companyType,
            'phase' => $phase,
        ];
        return view('articles.index', $data);
    }

    public function search(Request $request)
    {

        $query = Article::query();
        $user = User::where('id', Auth::id())->first();
        //検索用のラジオボタン用のデータ
        $prefecture = config('forSerchByPrefecture');
        $companyType = config('forSerchByCompanyType');
        $phase = config('forSerchByPhase');

        $prefectureSerch = $request->prefectureSearch;
        $companySearch = $request->companySearch;
        $phaseSearch = $request->phaseSearch;

        if($prefectureSerch !== "0") {
            $query->where('prefecture_id', $prefectureSerch);
        }

        if($companySearch  !== "0") {
            $query->where('company_type_id', $companySearch );
        }

        if($phaseSearch !== "0") {
            $query->where('phase_id', $phaseSearch);
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(3);

        $searchConditions = [$prefectureSerch, $companySearch, $phaseSearch];

        return view('articles.index', [
            'articles' => $articles,
            'user' => $user,
            'prefecture' => $prefecture,
            'companyType' => $companyType,
            'phase' => $phase,
            'searchConditions' => $searchConditions,
        ]);
    }
}
