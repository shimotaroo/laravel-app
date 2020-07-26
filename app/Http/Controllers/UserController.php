<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //ユーザーページ表示
    public function show(string $name)
    {
        $user = User::where('name', $name)->first();
        //投稿した記事
        $postArticles = $user->articles->sortByDesc('created_at');
        //いいねした記事
        $likeArticles = $user->likes->sortByDesc('created_at');

        return view('users.show', [
            'user' => $user,
            'postArticles' => $postArticles,
            'likeArticles' => $likeArticles,
        ]);
    }

    //プロフィール編集画面
    public function edit(string $name)
    {
        $user = User::where('name', $name)->first();

        return view('users.edit', ['user' => $user]);
    }

    //プロフィール編集処理
}
