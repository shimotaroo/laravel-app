<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index()
    {

        $articles = DB::table('articles')
            ->join('users', 'user_id', '=', 'users.id')
            ->join('prefectures', 'prefecture_id', '=', 'prefectures.id')
            ->join('company_types', 'company_type_id', '=', 'company_types.id')
            ->join('phases', 'phase_id', '=', 'phases.id')
            ->select('users.name', 'articles.created_at', 'prefectures.prefecture', 'company_types.company_type', 'phases.phase', 'question_content', 'other_information', 'impression')
            ->get();

        return view('articles.index', ['articles' => $articles]);
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(ArticleRequest $request, Article $article)
    {
        $article->prefecture_id = $request->prefecture_id;
        $article->company_type_id = $request->company_type_id;
        $article->phase_id = $request->phase_id;
        $article->question_content = $request->question_content;
        $article->other_information = $request->other_information;
        $article->impression = $request->impression;
        $article->user_id = $request->user()->id;
        $article->save();
        return redirect()->route('articles.index');
    }


}
