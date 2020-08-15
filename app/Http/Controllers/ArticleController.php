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
        $all_articles = Article::orderBy('created_at', 'desc');
        $articles = $all_articles->with(['user','prefecture', 'companyType', 'phase', 'likes'])->paginate(5);
        $articles_count = $all_articles->count();
        $user = User::where('id', Auth::id())->first();
        $sort = "新しい順";

        //検索用のラジオボタン用のデータ
        $prefecture = config('forSerchByPrefecture');
        $company_type = config('forSerchByCompanyType');
        $phase = config('forSerchByPhase');

        return view('articles.index', [
            'articles' => $articles,
            'user' => $user,
            'prefecture' => $prefecture,
            'company_type' => $company_type,
            'phase' => $phase,
            'sort' => $sort,
            'articles_count' => $articles_count,
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
    public function sort(string $sort_type)
    {
        $user = User::where('id', Auth::id())->first();
        $Article = new Article;
        $all_articles_by_sort = $Article->sortByselectedSortType($sort_type)->with(['user','prefecture', 'companyType', 'phase', 'likes']);
        $articles = $all_articles_by_sort->paginate(3);
        $articles_count = $all_articles_by_sort->count();

        //検索用のラジオボタン用のデータ
        $prefecture = config('forSerchByPrefecture');
        $company_type = config('forSerchByCompanyType');
        $phase = config('forSerchByPhase');

        switch($sort_type) {
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
            'sortType' => $sort_type,
            'prefecture' => $prefecture,
            'company_type' => $company_type,
            'phase' => $phase,
            'sort' => $sort,
            'articles_count' => $articles_count,
        ];
        return view('articles.index', $data);
    }

    public function search(Request $request)
    {
        $prefecture_serch = $request->prefecture_search;
        $company_search = $request->company_search;
        $phase_search = $request->phase_search;

        $query = Article::query();
        $user = User::where('id', Auth::id())->first();
        //検索用のラジオボタン用のデータ
        $prefecture = config('forSerchByPrefecture');
        $company_type = config('forSerchByCompanyType');
        $phase = config('forSerchByPhase');

        $sort = "新しい順";

        //DBからデータ取得
        if($prefecture_serch !== "0") {
            $query->where('prefecture_id', $prefecture_serch);
            $search_condition_for_prefecture = Prefecture::find($prefecture_serch)->prefecture;
        } else {
            $search_condition_for_prefecture = '指定なし';
        }
        if($company_search  !== "0") {
            $query->where('company_type_id', $company_search );
            $search_condition_for_company = CompanyType::find($company_search)->company_type;
        } else {
            $search_condition_for_company = '指定なし';
        }
        if($phase_search !== "0") {
            $query->where('phase_id', $phase_search);
            $search_condition_for_phase = Phase::find($phase_search)->phase;
        } else {
            $search_condition_for_phase = '指定なし';
        }

        $all_articles_by_search = $query->orderBy('created_at', 'desc')->with(['user','prefecture', 'companyType', 'phase', 'likes']);
        $articles = $all_articles_by_search->paginate(3);
        $articles_count = $all_articles_by_search->count();

        $search_conditions = [$prefecture_serch, $company_search, $phase_search];

        return view('articles.index', [
            'articles' => $articles,
            'user' => $user,
            'prefecture' => $prefecture,
            'company_type' => $company_type,
            'phase' => $phase,
            'search_conditions' => $search_conditions,
            'sort' => $sort,
            'articles_count' => $articles_count,
            'search_condition_for_prefecture' => $search_condition_for_prefecture,
            'search_condition_for_company' => $search_condition_for_company,
            'search_condition_for_phase' => $search_condition_for_phase
        ]);
    }
}
