<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //ユーザーページ表示
    public function show(string $name)
    {
        $user = User::where('name', $name)->first()->load(['articles.user', 'articles.prefecture', 'articles.companyType', 'articles.phase', 'articles.likes']);
        //投稿した記事
        $post_articles = $user->articles->sortByDesc('created_at');
        //いいねした記事
        $like_articles = $user->likes->sortByDesc('created_at');

        return view('users.show', [
            'user' => $user,
            'post_articles' => $post_articles,
            'like_articles' => $like_articles,
        ]);
    }

    //プロフィール編集画面
    public function edit(string $name)
    {
        $user = User::where('name', $name)->first();

        return view('users.edit', ['user' => $user]);
    }

    //プロフィール編集処理
    public function update(UserRequest $request, string $name)
    {

        $user = User::where('name', $name)->first();
        $all_request = $request->all();

        if (isset($all_request['image'])) {
            $profile_image = $request->file('image');
            $upload_info = Storage::disk('s3')->putFile('image', $profile_image, 'public');
            $all_request['image'] = Storage::disk('s3')->url($upload_info);
            $user->fill($all_request)->save();
        }

        return redirect()->route('users.show', ["name" => $user->name]);
    }

    //パスワード編集画面
    public function editPassword(string $name)
    {
        $user = User::where('name', $name)->first();

        return view('users.password_edit', ['user' => $user]);
    }

    //パスワード編集処理
    public function updatePassword(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        //現在のパスワードが合っているかチェック
        if(!(Hash::check($request->current_password, $user->password)))
        {
            return redirect()->back()
                ->withInput()->withErrors(['current_password' => '現在のパスワードが違います']);
        }

        //現在のパスワードと新しいパスワードが違うかチェック
        if($request->current_password === $request->password)
        {
            return redirect()->back()
                ->withInput()->withErrors(['password' => '現在のパスワードと新しいパスワードが変わっていません']);
        }

        $this->passwordValidator($request->all())->validate();

        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('users.show', ["name" => $user->name]);
    }

    public function passwordValidator(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}

