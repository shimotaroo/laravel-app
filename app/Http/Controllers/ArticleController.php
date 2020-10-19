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
        $radio_data = $this->getDataOfRadio();

        $data = [
            'articles' => $articles,
            'user' => $user,
            'prefecture' => $radio_data['prefecture'],
            'company_type' => $radio_data['company_type'],
            'phase' => $radio_data['phase'],
            'sort' => $sort,
            'articles_count' => $articles_count,
        ];

        return view('articles.index', $data);
    }

    //投稿画面
    public function create()
    {
        $article = null;
        $user = User::where('id', Auth::id())->first();

        $data = [
            'article' => $article,
            'user' => $user,
        ];

        return view('articles.create', $data);
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

        $data = [
            'article' => $article,
            'user' => $user,
        ];

        return view('articles.edit', $data);
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

        $data = [
            'article' => $article,
            'user' => $user,
        ];

        return view('articles.show', $data);
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
        $radio_data = $this->getDataOfRadio();

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
            'prefecture' => $radio_data['prefecture'],
            'company_type' => $radio_data['company_type'],
            'phase' => $radio_data['phase'],
            'sort' => $sort,
            'articles_count' => $articles_count,
        ];
        return view('articles.index', $data);
    }

    public function search(Request $request)
    {
        $prefecture_search = $request->prefecture_search;
        $company_search = $request->company_search;
        $phase_search = $request->phase_search;
        $Article = new Article;
        $user = User::where('id', Auth::id())->first();
        //検索用のラジオボタン用のデータ
        $radio_data = $this->getDataOfRadio();

        $sort = "新しい順";

        $query = $Article->query();
        $search_query = $Article->makeQueryOfSearch($query, $prefecture_search, $company_search, $phase_search);
        $search_conditions = $Article->getSearchConditions($prefecture_search, $company_search, $phase_search);

        $all_articles_by_search = $search_query->orderBy('created_at', 'desc')->with(['user','prefecture', 'companyType', 'phase', 'likes']);
        $articles = $all_articles_by_search->paginate(3);
        $articles_count = $all_articles_by_search->count();

        //ページネーション用データ
        $search_conditions_pagination = [$prefecture_search, $company_search, $phase_search];

        $data = [
            'articles' => $articles,
            'user' => $user,
            'prefecture' => $radio_data['prefecture'],
            'company_type' => $radio_data['company_type'],
            'phase' => $radio_data['phase'],
            'search_conditions_pagination' => $search_conditions_pagination,
            'sort' => $sort,
            'articles_count' => $articles_count,
            'search_condition_prefecture' => $search_conditions['prefecture'],
            'search_condition_company' => $search_conditions['company'],
            'search_condition_phase' => $search_conditions['phase'],
        ];

        return view('articles.index', $data);
    }

    //検索ラジオボタン用のデータ
    private function getDataOfRadio()
    {
        return [
            'prefecture' => config('forSerchByPrefecture'),
            'company_type' => config('forSerchByCompanyType'),
            'phase' => config('forSerchByPhase'),
        ];
    }
}
