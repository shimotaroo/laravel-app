<?php

namespace App\Http\Controllers;

use App\Article;
use App\CompanyType;
use App\Http\Requests\ArticleRequest;
use App\Phase;
use App\Prefecture;
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
        $allArticles = Article::orderBy('created_at', 'desc');
        $articles = $allArticles->with(['user','prefecture', 'companyType', 'phase', 'likes'])->paginate(5);
        $articlesCount = $allArticles->count();
        $user = User::where('id', Auth::id())->first();
        $sort = "新しい順";

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
            'sort' => $sort,
            'articlesCount' => $articlesCount,
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
        $user = User::where('id', Auth::id())->first();
        return view('articles.edit', [
            'article' => $article,
            'user' => $user,
            ]);
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
        $user = User::where('id', Auth::id())->first();

        return view('articles.show', [
            'article' => $article,
            'user' => $user,
            ]);
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
        $allArticlesBySort = $Article->sortByselectedSortType($sortType)->with(['user','prefecture', 'companyType', 'phase', 'likes']);
        $articles = $allArticlesBySort->paginate(3);
        $articlesCount = $allArticlesBySort->count();

        //検索用のラジオボタン用のデータ
        $prefecture = config('forSerchByPrefecture');
        $companyType = config('forSerchByCompanyType');
        $phase = config('forSerchByPhase');

        switch($sortType) {
            case 'desc':
                $sort = '新しい順';
                break;
            case 'asc':
                $sort = '古い順';
                break;
            case 'like_count':
                $sort = 'いいね数順';
                break;
                    }

        $data = [
            'articles' => $articles,
            'user' => $user,
            'sortType' => $sortType,
            'prefecture' => $prefecture,
            'companyType' => $companyType,
            'phase' => $phase,
            'sort' => $sort,
            'articlesCount' => $articlesCount,
        ];
        return view('articles.index', $data);
    }

    public function search(Request $request)
    {
        $prefectureSerch = $request->prefectureSearch;
        $companySearch = $request->companySearch;
        $phaseSearch = $request->phaseSearch;

        $query = Article::query();
        $user = User::where('id', Auth::id())->first();
        //検索用のラジオボタン用のデータ
        $prefecture = config('forSerchByPrefecture');
        $companyType = config('forSerchByCompanyType');
        $phase = config('forSerchByPhase');

        $sort = "新しい順";

        //DBからデータ取得
        if($prefectureSerch !== "0") {
            $query->where('prefecture_id', $prefectureSerch);
            $searchConditionForPrefecture = Prefecture::find($prefectureSerch)->prefecture;
        } else {
            $searchConditionForPrefecture = '指定なし';
        }
        if($companySearch  !== "0") {
            $query->where('company_type_id', $companySearch );
            $searchConditionForCompany = CompanyType::find($companySearch)->company_type;
        } else {
            $searchConditionForCompany = '指定なし';
        }
        if($phaseSearch !== "0") {
            $query->where('phase_id', $phaseSearch);
            $searchConditionForPhase = Phase::find($phaseSearch)->phase;
        } else {
            $searchConditionForPhase = '指定なし';
        }

        $allArticlesBySearch = $query->orderBy('created_at', 'desc')->with(['user','prefecture', 'companyType', 'phase', 'likes']);
        $articles = $allArticlesBySearch->paginate(3);
        $articlesCount = $allArticlesBySearch->count();

        $searchConditions = [$prefectureSerch, $companySearch, $phaseSearch];

        return view('articles.index', [
            'articles' => $articles,
            'user' => $user,
            'prefecture' => $prefecture,
            'companyType' => $companyType,
            'phase' => $phase,
            'searchConditions' => $searchConditions,
            'sort' => $sort,
            'articlesCount' => $articlesCount,
            'searchConditionForPrefecture' => $searchConditionForPrefecture,
            'searchConditionForCompany' => $searchConditionForCompany,
            'searchConditionForPhase' => $searchConditionForPhase
        ]);
    }
}
