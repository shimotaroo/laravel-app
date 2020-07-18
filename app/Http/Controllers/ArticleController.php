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
        // $articles = Article::with(['prefecture', 'companyType', 'phase'])->get();
        $articles = Article::all();
        return view('articles.index', ['articles' => $articles]);
    }

    //投稿画面
    public function create()
    {
        $article = null;
        return view('articles.create', ['article' => $article]);
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




}
